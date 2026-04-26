<?php

namespace App\Services\Video;

use App\Models\Course;
use App\Models\LiveClass;
use App\Models\User;
use DateTimeInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class JitsiMeetService
{
    /**
     * Generate a unique, hard-to-guess room name for a class.
     */
    public function makeRoomName(Course $course, string $title, ?DateTimeInterface $scheduledAt = null): string
    {
        $dateSegment = ($scheduledAt === null ? now() : Carbon::parse($scheduledAt))->format('YmdHi');

        return Str::of(implode('-', [
            (string) config('services.jitsi.room_prefix', 'jackie-lms'),
            $course->slug,
            $title,
            $dateSegment,
            Str::lower((string) Str::ulid()),
        ]))->slug('-')->toString();
    }

    /**
     * Build the browser URL that opens a Jitsi room directly.
     */
    public function joinUrl(string $roomName): string
    {
        return sprintf('%s://%s/%s', $this->scheme(), $this->domain(), rawurlencode($roomName));
    }

    /**
     * Build the payload a frontend needs to instantiate JitsiMeetExternalAPI.
     *
     * @return array<string, mixed>
     */
    public function meetingPayload(LiveClass $liveClass, User $user, bool $moderator = false): array
    {
        return [
            'provider' => 'jitsi',
            'domain' => $this->domain(),
            'external_api_url' => $this->externalApiUrl(),
            'room_name' => $liveClass->room_name,
            'join_url' => $liveClass->join_url ?? $this->joinUrl($liveClass->room_name),
            'can_join' => $liveClass->isJoinable(),
            'starts_at' => $liveClass->scheduled_at,
            'ends_at' => $liveClass->endsAt(),
            'iframe' => [
                'domain' => $this->domain(),
                'options' => [
                    'roomName' => $liveClass->room_name,
                    'width' => '100%',
                    'height' => '100%',
                    'lang' => config('services.jitsi.default_language', 'en'),
                    'jwt' => null,
                    'userInfo' => [
                        'email' => $user->email,
                        'displayName' => $user->name,
                    ],
                    'configOverwrite' => $this->configOverwrite($liveClass, $moderator),
                    'interfaceConfigOverwrite' => $this->interfaceConfigOverwrite($liveClass),
                ],
            ],
            'mobile' => [
                'android_intent_url' => sprintf(
                    'intent://%s/%s#Intent;scheme=org.jitsi.meet;package=org.jitsi.meet;end',
                    $this->domain(),
                    rawurlencode($liveClass->room_name),
                ),
                'ios_url' => sprintf('org.jitsi.meet://%s/%s', $this->domain(), rawurlencode($liveClass->room_name)),
            ],
        ];
    }

    /**
     * Build Jitsi config overrides.
     *
     * @return array<string, mixed>
     */
    private function configOverwrite(LiveClass $liveClass, bool $moderator): array
    {
        return [
            'disableInviteFunctions' => true,
            'prejoinPageEnabled' => false,
            'enableWelcomePage' => false,
            'startWithAudioMuted' => ! $moderator,
            'startWithVideoMuted' => ! $moderator,
            ...Arr::get($liveClass->settings ?? [], 'configOverwrite', []),
        ];
    }

    /**
     * Build Jitsi interface overrides.
     *
     * @return array<string, mixed>
     */
    private function interfaceConfigOverwrite(LiveClass $liveClass): array
    {
        return [
            'DISABLE_JOIN_LEAVE_NOTIFICATIONS' => true,
            'MOBILE_APP_PROMO' => false,
            'SHOW_PROMOTIONAL_CLOSE_BUTTON' => false,
            'SHOW_JITSI_WATERMARK' => false,
            ...Arr::get($liveClass->settings ?? [], 'interfaceConfigOverwrite', []),
        ];
    }

    /**
     * Resolve the configured Jitsi deployment domain.
     */
    private function domain(): string
    {
        return trim((string) config('services.jitsi.domain', 'meet.jit.si'), '/');
    }

    /**
     * Resolve the configured Jitsi URL scheme.
     */
    private function scheme(): string
    {
        return (string) config('services.jitsi.scheme', 'https');
    }

    /**
     * Resolve the external API script URL for the iframe API.
     */
    private function externalApiUrl(): string
    {
        $configuredUrl = config('services.jitsi.external_api_url');

        if (is_string($configuredUrl) && $configuredUrl !== '') {
            return $configuredUrl;
        }

        return sprintf('%s://%s/external_api.js', $this->scheme(), $this->domain());
    }
}
