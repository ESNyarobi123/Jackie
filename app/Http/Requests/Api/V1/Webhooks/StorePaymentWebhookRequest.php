<?php

namespace App\Http\Requests\Api\V1\Webhooks;

use App\Enums\PaymentProvider;
use App\Services\Payment\ClickPesaService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StorePaymentWebhookRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'provider' => $this->route('provider'),
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'provider' => ['required', Rule::enum(PaymentProvider::class)],
            'event' => ['nullable', 'string', 'max:100'],
            'reference' => ['required_without_all:data.orderReference,orderReference', 'nullable', 'string', 'max:255'],
            'orderReference' => ['required_without_all:reference,data.orderReference', 'nullable', 'string', 'max:255'],
            'id' => ['nullable', 'string', 'max:255'],
            'provider_reference' => ['nullable', 'string', 'max:255'],
            'paymentReference' => ['nullable', 'string', 'max:255'],
            'paymentPhoneNumber' => ['nullable', 'string', 'max:50'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'course_id' => ['nullable', 'integer', 'exists:courses,id'],
            'amount' => ['required_without_all:data.collectedAmount,collectedAmount', 'nullable', 'numeric', 'min:0'],
            'collectedAmount' => ['required_without_all:amount,data.collectedAmount', 'nullable', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'size:3'],
            'collectedCurrency' => ['nullable', 'string', 'size:3'],
            'status' => ['required_without:data.status', 'nullable', 'string', 'max:50'],
            'paid_at' => ['nullable', 'date'],
            'failed_at' => ['nullable', 'date'],
            'updatedAt' => ['nullable', 'date'],
            'createdAt' => ['nullable', 'date'],
            'message' => ['nullable', 'string', 'max:255'],
            'customer' => ['nullable', 'array'],
            'clientId' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'payload' => ['nullable', 'array'],
            'checksum' => ['nullable', 'string', 'max:255'],
            'checksumMethod' => ['nullable', 'string', 'max:50'],
            'data' => ['nullable', 'array'],
            'data.id' => ['nullable', 'string', 'max:255'],
            'data.status' => ['required_without:status', 'nullable', 'string', 'max:50'],
            'data.paymentReference' => ['nullable', 'string', 'max:255'],
            'data.paymentPhoneNumber' => ['nullable', 'string', 'max:50'],
            'data.orderReference' => ['required_without_all:reference,orderReference', 'nullable', 'string', 'max:255'],
            'data.collectedAmount' => ['required_without_all:amount,collectedAmount', 'nullable', 'numeric', 'min:0'],
            'data.collectedCurrency' => ['nullable', 'string', 'size:3'],
            'data.message' => ['nullable', 'string', 'max:255'],
            'data.updatedAt' => ['nullable', 'date'],
            'data.createdAt' => ['nullable', 'date'],
            'data.customer' => ['nullable', 'array'],
            'data.clientId' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Configure extra validation callbacks.
     *
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $provider = (string) $this->route('provider');

                if ($provider === PaymentProvider::Manual->value && ! config('services.payment_webhooks.allow_manual')) {
                    $validator->errors()->add('provider', 'Manual payment webhooks are disabled.');

                    return;
                }

                if ($provider === PaymentProvider::ClickPesa->value) {
                    if (! app(ClickPesaService::class)->hasValidChecksum($this->all())) {
                        $validator->errors()->add('checksum', 'The ClickPesa webhook checksum is invalid.');
                    }

                    return;
                }

                if (! $this->hasValidSharedSecret()) {
                    $validator->errors()->add('signature', 'The payment webhook signature is invalid.');
                }
            },
        ];
    }

    /**
     * Verify webhooks that do not provide a provider-specific checksum yet.
     */
    private function hasValidSharedSecret(): bool
    {
        $secret = config('services.payment_webhooks.secret');

        if (! is_string($secret) || $secret === '') {
            return false;
        }

        $providedSecret = (string) $this->header('X-Webhook-Secret', '');

        return hash_equals($secret, $providedSecret);
    }
}
