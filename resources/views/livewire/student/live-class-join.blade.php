<div class="space-y-5" wire:ignore.self>
    {{-- Header --}}
    <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
        <div>
            <a class="text-sm text-[rgba(30,41,59,0.6)] hover:underline" href="{{ route('student.live-classes') }}" wire:navigate>
                Back
            </a>
            <h1 class="mt-2 text-2xl font-black tracking-tight text-(--color-smoke)">{{ $liveClass->title }}</h1>
            <p class="mt-1 text-sm text-[rgba(30,41,59,0.62)]">
                {{ $liveClass->course?->title }} / {{ $liveClass->scheduled_at?->format('M d, h:i A') }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            @if($canJoin)
                <span class="pill pill-green">🔴 Live</span>
                <a href="{{ $liveClass->join_url ?? '#' }}" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all hover:scale-105"
                   style="background: var(--color-terra); color: var(--color-ivory);">
                    ↗ Open in new tab
                </a>
            @else
                <span class="pill pill-blue">Opens soon</span>
            @endif
        </div>
    </div>

    @if($canJoin)
        {{-- Floating PiP Jitsi Panel --}}
        <div id="jitsi-pip-wrapper"
             class="fixed bottom-4 right-4 z-50 flex flex-col rounded-2xl overflow-hidden shadow-2xl border border-[rgba(30,41,59,0.1)]"
             style="width: min(480px, calc(100vw - 2rem)); height: min(360px, calc(100vh - 6rem)); background: #1a1a1a;"
             data-default-width="480" data-default-height="360">

            {{-- Drag handle + controls --}}
            <div id="jitsi-pip-header"
                 class="flex items-center justify-between px-3 py-2 cursor-move select-none"
                 style="background: rgba(0,0,0,.7);"
                 onmousedown="startDrag(event)" ontouchstart="startDrag(event)">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                    <span class="text-xs font-semibold text-white truncate">{{ $liveClass->title }}</span>
                </div>
                <div class="flex items-center gap-1">
                    <button onclick="togglePipSize()" class="text-white/70 hover:text-white p-1 rounded transition-colors" title="Resize">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>
                    </button>
                    <button onclick="togglePipMinimize()" id="btn-minimize" class="text-white/70 hover:text-white p-1 rounded transition-colors" title="Minimize">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </button>
                </div>
            </div>

            {{-- Jitsi mount point --}}
            <div id="student-jitsi-meet" class="flex-1"></div>
        </div>

        {{-- Minimized pill (hidden by default) --}}
        <button id="jitsi-pip-minimized"
                onclick="togglePipMinimize()"
                class="fixed bottom-4 right-4 z-50 hidden items-center gap-2 px-4 py-2.5 rounded-full shadow-2xl transition-all hover:scale-105"
                style="background: #ef4444; color: white;">
            <div class="w-2 h-2 rounded-full bg-white animate-pulse"></div>
            <span class="text-xs font-bold">Live Class</span>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 3 21 3 21 9"/><line x1="21" y1="3" x2="14" y2="10"/></svg>
        </button>

        {{-- Main content area (course info, chat, etc.) --}}
        <div class="glass-card p-6 glass-soft-shadow">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg" style="background: linear-gradient(135deg, rgba(245,130,32,.15), rgba(245,130,32,.05));">🎥</div>
                <div>
                    <h2 class="text-lg font-bold text-(--color-smoke)">{{ $liveClass->title }}</h2>
                    <p class="text-xs text-[rgba(30,41,59,0.6)]">{{ $liveClass->course?->title }} · {{ $liveClass->duration_minutes }} min</p>
                </div>
            </div>

            @if($liveClass->description)
                <p class="text-sm text-[rgba(30,41,59,0.7)] mb-4">{{ $liveClass->description }}</p>
            @endif

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('dashboard') }}" wire:navigate
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold transition-all hover:scale-105"
                   style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.25);">
                    📊 Dashboard
                </a>
                <a href="{{ route('student.courses') }}" wire:navigate
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold transition-all hover:scale-105 btn-glass-outline">
                    📚 My Courses
                </a>
                <a href="{{ route('student.live-classes') }}" wire:navigate
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold transition-all hover:scale-105 btn-glass-outline">
                    📅 All Live Classes
                </a>
            </div>
        </div>

        <script>
            // ── Drag logic ──
            let isDragging = false, dragOffsetX = 0, dragOffsetY = 0;

            function startDrag(e) {
                isDragging = true;
                const panel = document.getElementById('jitsi-pip-wrapper');
                const rect = panel.getBoundingClientRect();
                const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                dragOffsetX = clientX - rect.left;
                dragOffsetY = clientY - rect.top;
                e.preventDefault();
            }

            document.addEventListener('mousemove', onDragMove);
            document.addEventListener('touchmove', onDragMove, { passive: false });
            document.addEventListener('mouseup', () => isDragging = false);
            document.addEventListener('touchend', () => isDragging = false);

            function onDragMove(e) {
                if (!isDragging) return;
                const panel = document.getElementById('jitsi-pip-wrapper');
                const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                let x = clientX - dragOffsetX;
                let y = clientY - dragOffsetY;
                x = Math.max(0, Math.min(x, window.innerWidth - panel.offsetWidth));
                y = Math.max(0, Math.min(y, window.innerHeight - panel.offsetHeight));
                panel.style.left = x + 'px';
                panel.style.top = y + 'px';
                panel.style.right = 'auto';
                panel.style.bottom = 'auto';
            }

            // ── Resize toggle ──
            let isExpanded = false;
            function togglePipSize() {
                const panel = document.getElementById('jitsi-pip-wrapper');
                isExpanded = !isExpanded;
                if (isExpanded) {
                    panel.style.width = 'min(720px, calc(100vw - 2rem))';
                    panel.style.height = 'min(540px, calc(100vh - 6rem))';
                } else {
                    panel.style.width = 'min(480px, calc(100vw - 2rem))';
                    panel.style.height = 'min(360px, calc(100vh - 6rem))';
                }
            }

            // ── Minimize toggle ──
            let isMinimized = false;
            function togglePipMinimize() {
                const panel = document.getElementById('jitsi-pip-wrapper');
                const pill = document.getElementById('jitsi-pip-minimized');
                isMinimized = !isMinimized;
                panel.style.display = isMinimized ? 'none' : 'flex';
                pill.style.display = isMinimized ? 'flex' : 'none';
            }

            // ── Init Jitsi (only once) ──
            (function initStudentJitsi() {
                const payload = @js($meeting);
                if (!payload || payload.provider !== 'jitsi') return;

                const mountPoint = document.getElementById('student-jitsi-meet');
                if (!mountPoint || mountPoint.querySelector('iframe')) return;

                const scriptId = 'jitsi-external-api';
                if (!document.getElementById(scriptId)) {
                    const script = document.createElement('script');
                    script.id = scriptId;
                    script.src = payload.external_api_url;
                    script.async = true;
                    script.onload = () => mountJitsi(payload, mountPoint);
                    document.head.appendChild(script);
                } else {
                    mountJitsi(payload, mountPoint);
                }

                function mountJitsi(payload, parentNode) {
                    if (!window.JitsiMeetExternalAPI) return;
                    const options = payload.iframe?.options ?? {};
                    options.parentNode = parentNode;
                    new window.JitsiMeetExternalAPI(payload.domain, options);
                }
            })();
        </script>
    @else
        <div class="glass-card p-8 text-center glass-soft-shadow">
            <div class="mx-auto mb-4 h-16 w-16 rounded-2xl flex items-center justify-center text-2xl" style="background: linear-gradient(135deg, rgba(245,130,32,.12), rgba(245,130,32,.04));">🔒</div>
            <h2 class="text-xl font-black text-(--color-smoke)">
                @if($liveClass->status?->value === 'live')
                    Room is Starting...
                @else
                    Class room is locked
                @endif
            </h2>
            <p class="mx-auto mt-2 max-w-md text-sm text-[rgba(30,41,59,0.62)]">
                @if($liveClass->status?->value === 'live')
                    The host is setting up the room. You'll be able to join momentarily — please refresh in a few seconds.
                @else
                    You can join {{ config('services.jitsi.join_window_before_minutes', 15) }} minutes before the lesson starts.
                    <br>
                    <span class="text-(--color-terra) font-medium">Opens at: {{ $liveClass->scheduled_at?->copy()->subMinutes(config('services.jitsi.join_window_before_minutes', 15))->format('h:i A') }}</span>
                @endif
            </p>
            <div class="mt-4">
                <button onclick="location.reload()" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold transition-all hover:scale-105" style="background: var(--color-terra); color: var(--color-ivory); box-shadow: 0 4px 14px rgba(245,130,32,.25);">
                    🔄 Refresh Page
                </button>
            </div>
        </div>
    @endif
</div>
