<?php

namespace App\Services\Payment;

use App\Enums\PaymentStatus;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ClickPesaService
{
    /**
     * Generate or retrieve a cached ClickPesa bearer token.
     */
    public function token(): string
    {
        return Cache::remember(
            (string) config('services.clickpesa.token_cache_key', 'clickpesa.token'),
            now()->addMinutes(55),
            function (): string {
                $baseUrl = (string) config('services.clickpesa.base_url');
                $clientId = (string) config('services.clickpesa.client_id');
                $apiKey = (string) config('services.clickpesa.api_key');

                Log::info('ClickPesa token request', [
                    'base_url' => $baseUrl,
                    'client_id' => $clientId,
                    'api_key_length' => strlen($apiKey),
                    'api_key_start' => substr($apiKey, 0, 6),
                ]);

                $response = Http::baseUrl($baseUrl)
                    ->acceptJson()
                    ->timeout((int) config('services.clickpesa.timeout', 20))
                    ->connectTimeout((int) config('services.clickpesa.connect_timeout', 10))
                    ->withHeaders([
                        'client-id' => $clientId,
                        'api-key' => $apiKey,
                    ])
                    ->post('/generate-token');

                Log::info('ClickPesa token response', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                $response->throw();

                $token = (string) $response->json('token');

                // ClickPesa returns token with "Bearer " prefix — strip it
                // since authenticatedRequest() adds its own "Bearer " prefix
                return str_starts_with($token, 'Bearer ') ? substr($token, 7) : $token;
            },
        );
    }

    /**
     * Preview a mobile money USSD push request before prompting the customer.
     *
     * @return array<string, mixed>
     */
    public function previewUssdPush(
        string $amount,
        string $currency,
        string $orderReference,
        string $phoneNumber,
        bool $fetchSenderDetails = true,
    ): array {
        return $this->authenticatedRequest()
            ->post('/payments/preview-ussd-push-request', $this->withChecksum([
                'amount' => $amount,
                'currency' => $currency,
                'orderReference' => $orderReference,
                'phoneNumber' => $phoneNumber,
                'fetchSenderDetails' => $fetchSenderDetails,
            ]))
            ->throw()
            ->json();
    }

    /**
     * Initiate a mobile money USSD push request.
     *
     * @return array<string, mixed>
     */
    public function initiateUssdPush(
        string $amount,
        string $currency,
        string $orderReference,
        string $phoneNumber,
    ): array {
        return $this->authenticatedRequest()
            ->post('/payments/initiate-ussd-push-request', $this->withChecksum([
                'amount' => $amount,
                'currency' => $currency,
                'orderReference' => $orderReference,
                'phoneNumber' => $phoneNumber,
            ]))
            ->throw()
            ->json();
    }

    /**
     * Query ClickPesa for payment status by order reference.
     *
     * @return array<string|int, mixed>
     */
    public function queryPaymentStatus(string $orderReference): array
    {
        return $this->authenticatedRequest()
            ->get('/payments/'.$orderReference)
            ->throw()
            ->json();
    }

    /**
     * Pick the newest payment record from ClickPesa's status response.
     *
     * @param  array<string|int, mixed>  $payload
     * @return array<string, mixed>|null
     */
    public function latestPaymentRecord(array $payload): ?array
    {
        $records = Arr::get($payload, 'data', $payload);

        if (! is_array($records)) {
            return null;
        }

        if (! array_is_list($records)) {
            $records = [$records];
        }

        /** @var array<string, mixed>|null $record */
        $record = collect($records)
            ->filter(fn (mixed $item): bool => is_array($item))
            ->sortByDesc(fn (array $item): string => (string) ($item['updatedAt'] ?? $item['createdAt'] ?? ''))
            ->first();

        return $record;
    }

    /**
     * Create a checksum-compatible payment reference.
     */
    public function makeOrderReference(): string
    {
        return 'CP-'.Str::upper((string) Str::ulid());
    }

    /**
     * Map ClickPesa status values into the application's payment status values.
     */
    public function mapPaymentStatus(?string $status): PaymentStatus
    {
        return match (Str::upper((string) $status)) {
            'SUCCESS', 'SETTLED' => PaymentStatus::Paid,
            'FAILED' => PaymentStatus::Failed,
            'REFUNDED', 'REVERSED' => PaymentStatus::Refunded,
            default => PaymentStatus::Pending,
        };
    }

    /**
     * Validate a ClickPesa checksum from a webhook payload.
     *
     * @param  array<string, mixed>  $payload
     */
    public function hasValidChecksum(array $payload): bool
    {
        if (! (bool) config('services.clickpesa.checksum_enabled', false)) {
            return true;
        }

        $receivedChecksum = Arr::get($payload, 'checksum');

        if (! is_string($receivedChecksum) || $receivedChecksum === '') {
            return false;
        }

        return hash_equals($receivedChecksum, $this->checksum($payload));
    }

    /**
     * Create a HMAC-SHA256 checksum from canonical JSON.
     *
     * @param  array<string, mixed>  $payload
     */
    public function checksum(array $payload): string
    {
        unset($payload['checksum'], $payload['checksumMethod']);

        return hash_hmac(
            'sha256',
            json_encode($this->canonicalize($payload), JSON_UNESCAPED_SLASHES),
            (string) config('services.clickpesa.checksum_key'),
        );
    }

    /**
     * Add a checksum to an outgoing payload when enabled.
     *
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    private function withChecksum(array $payload): array
    {
        if (! (bool) config('services.clickpesa.checksum_enabled', false)) {
            return $payload;
        }

        return [
            ...$payload,
            'checksum' => $this->checksum($payload),
        ];
    }

    /**
     * Build an unauthenticated ClickPesa HTTP client.
     */
    private function baseRequest(): PendingRequest
    {
        return Http::baseUrl((string) config('services.clickpesa.base_url'))
            ->acceptJson()
            ->asJson()
            ->timeout((int) config('services.clickpesa.timeout', 20))
            ->connectTimeout((int) config('services.clickpesa.connect_timeout', 10))
            ->retry(
                (int) config('services.clickpesa.retry_times', 2),
                (int) config('services.clickpesa.retry_sleep_ms', 250),
                throw: false,
            );
    }

    /**
     * Build an authenticated ClickPesa HTTP client.
     */
    private function authenticatedRequest(): PendingRequest
    {
        return $this->baseRequest()
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->token(),
            ]);
    }

    /**
     * Recursively sort associative object keys before JSON serialization.
     *
     * @param  mixed  $value
     * @return mixed
     */
    private function canonicalize(mixed $value): mixed
    {
        if (! is_array($value)) {
            return $value;
        }

        if (array_is_list($value)) {
            return array_map(fn (mixed $item): mixed => $this->canonicalize($item), $value);
        }

        ksort($value);

        return collect($value)
            ->map(fn (mixed $item): mixed => $this->canonicalize($item))
            ->all();
    }
}
