<div class="space-y-6" wire:ignore.self>
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <a class="text-sm text-[rgba(30,41,59,0.6)] hover:underline" href="{{ route('admin.live-classes.show', $liveClass) }}" wire:navigate>
                Back to live class
            </a>
            <h1 class="text-2xl font-bold text-[var(--color-smoke)] mt-2">Join: {{ $liveClass->title }}</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">
                This uses the Jitsi iframe API (`external_api.js`).
            </p>
        </div>

        <div class="shrink-0 flex gap-2">
            @if($liveClass->join_url)
                <flux:button variant="ghost" href="{{ $liveClass->join_url }}" target="_blank">
                    Open in new tab
                </flux:button>
            @endif
        </div>
    </div>

    <div class="glass-card p-0 glass-soft-shadow overflow-hidden" style="height: calc(100vh - 280px); min-height: 520px;">
        <div id="jitsi-meet" style="width: 100%; height: 100%;"></div>
    </div>

    <script>
        (function initJitsi() {
            const payload = @js($meeting);

            if (!payload || payload.provider !== 'jitsi') return;

            const existing = document.querySelector('#jitsi-meet iframe');
            if (existing) return;

            const scriptId = 'jitsi-external-api';
            if (!document.getElementById(scriptId)) {
                const script = document.createElement('script');
                script.id = scriptId;
                script.src = payload.external_api_url;
                script.async = true;
                script.onload = () => mount(payload);
                document.head.appendChild(script);
            } else {
                mount(payload);
            }

            function mount(payload) {
                if (!window.JitsiMeetExternalAPI) return;

                const options = payload.iframe?.options ?? {};
                options.parentNode = document.getElementById('jitsi-meet');

                // eslint-disable-next-line no-new
                new window.JitsiMeetExternalAPI(payload.domain, options);
            }
        })();
    </script>
</div>
