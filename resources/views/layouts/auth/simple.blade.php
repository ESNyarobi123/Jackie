<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <style>
        /* ── Centered Auth Layout ── */
        .auth-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background: #1c1917;
            padding: 1.5rem;
        }

        /* Animated background orbs */
        .auth-bg-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }
        .auth-bg-orb-1 {
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(188,108,37,.35), transparent 70%);
            top: -15%; left: -10%;
            animation: authOrb1 22s ease-in-out infinite alternate;
        }
        .auth-bg-orb-2 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(245,130,32,.2), transparent 70%);
            bottom: -10%; right: -8%;
            animation: authOrb2 18s ease-in-out infinite alternate-reverse;
        }
        .auth-bg-orb-3 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,.08), transparent 70%);
            top: 40%; left: 55%;
            animation: authOrb3 25s ease-in-out infinite alternate;
        }
        @keyframes authOrb1 {
            0% { transform: translate(0,0) scale(1); }
            50% { transform: translate(40px,-30px) scale(1.08); }
            100% { transform: translate(-25px,20px) scale(.95); }
        }
        @keyframes authOrb2 {
            0% { transform: translate(0,0) scale(1); }
            50% { transform: translate(-35px,25px) scale(1.05); }
            100% { transform: translate(20px,-15px) scale(.98); }
        }
        @keyframes authOrb3 {
            0% { transform: translate(0,0) scale(1); }
            50% { transform: translate(20px,15px) scale(1.1); }
            100% { transform: translate(-30px,-20px) scale(.92); }
        }

        /* Grid pattern overlay */
        .auth-bg-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
            mask-image: radial-gradient(ellipse 60% 50% at 50% 50%, black, transparent);
            -webkit-mask-image: radial-gradient(ellipse 60% 50% at 50% 50%, black, transparent);
        }

        /* Form wrapper */
        .auth-form-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
        }

        /* Logo area */
        .auth-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .75rem;
            margin-bottom: 2rem;
        }
        .auth-logo-icon {
            width: 48px; height: 48px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--color-terra), #F58220);
            box-shadow: 0 8px 28px rgba(245,130,32,.35);
        }
        .auth-logo-text {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--color-ivory);
            letter-spacing: -.02em;
        }

        /* Glass card */
        .auth-glass-card {
            padding: 2.25rem;
            border-radius: 1.5rem;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.1);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            box-shadow:
                0 20px 60px rgba(0,0,0,.3),
                0 0 0 1px rgba(255,255,255,.05) inset,
                0 1px 0 rgba(255,255,255,.08) inset;
        }

        /* Back link */
        .auth-back-link {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .85rem;
            color: rgba(248,249,250,.5);
            text-decoration: none;
            margin-bottom: 1.5rem;
            transition: color .2s ease;
        }
        .auth-back-link:hover { color: var(--color-ivory); }

        /* Override Flux input styles inside auth card */
        .auth-glass-card [data-flux-field] { gap: .5rem; }
        .auth-glass-card label[data-flux-label] {
            color: rgba(248,249,250,.7) !important;
            font-weight: 500 !important;
        }
        .auth-glass-card input[data-flux-control] {
            background: rgba(255,255,255,.08) !important;
            border: 1px solid rgba(255,255,255,.12) !important;
            border-radius: .75rem !important;
            padding: .65rem 1rem !important;
            color: var(--color-ivory) !important;
            transition: all .2s ease !important;
        }
        .auth-glass-card input[data-flux-control]::placeholder {
            color: rgba(248,249,250,.3) !important;
        }
        .auth-glass-card input[data-flux-control]:focus {
            background: rgba(255,255,255,.12) !important;
            border-color: rgba(245,130,32,.4) !important;
            box-shadow: 0 0 0 3px rgba(245,130,32,.12) !important;
        }
        .auth-glass-card [data-flux-checkbox] {
            color: rgba(248,249,250,.7) !important;
        }
        .auth-glass-card a {
            color: var(--color-terra) !important;
        }

        /* Submit button */
        .auth-submit-btn {
            width: 100%;
            padding: .8rem 1.5rem;
            border-radius: .75rem;
            background: linear-gradient(135deg, var(--color-terra), #F58220);
            color: var(--color-ivory);
            font-weight: 700;
            font-size: .95rem;
            border: none;
            box-shadow: 0 8px 28px rgba(245,130,32,.25);
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease;
            position: relative;
            overflow: hidden;
        }
        .auth-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 36px rgba(245,130,32,.35);
        }
        .auth-submit-btn::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 60%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.15), transparent);
            animation: authShimmer 3s ease-in-out infinite;
        }
        @keyframes authShimmer {
            0% { left: -100%; }
            50% { left: 120%; }
            100% { left: 120%; }
        }

        /* Divider */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin: 1.25rem 0;
            font-size: .8rem;
            color: rgba(248,249,250,.35);
        }
        .auth-divider::before, .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,.1);
        }

        /* Alt link */
        .auth-alt-link {
            text-align: center;
            font-size: .85rem;
            color: rgba(248,249,250,.5);
        }
        .auth-alt-link a {
            color: var(--color-terra);
            font-weight: 600;
            text-decoration: none;
            transition: color .2s ease;
        }
        .auth-alt-link a:hover { color: #F58220; }

        /* Feature pills at bottom */
        .auth-features {
            display: flex;
            justify-content: center;
            gap: .75rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }
        .auth-feature-pill {
            display: flex;
            align-items: center;
            gap: .4rem;
            padding: .4rem .85rem;
            border-radius: 2rem;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.08);
            font-size: .75rem;
            color: rgba(248,249,250,.55);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
        .auth-feature-pill span:first-child {
            font-size: .85rem;
        }
    </style>
</head>
<body>
    <div class="auth-page">
        <!-- Background effects -->
        <div class="auth-bg-orb auth-bg-orb-1"></div>
        <div class="auth-bg-orb auth-bg-orb-2"></div>
        <div class="auth-bg-orb auth-bg-orb-3"></div>
        <div class="auth-bg-grid"></div>

        <!-- Form wrapper -->
        <div class="auth-form-wrapper">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="auth-logo" wire:navigate>
                <div class="auth-logo-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M7 13h10M7 9h10M7 17h6" stroke="var(--color-ivory)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="auth-logo-text">JackieEnglish</span>
            </a>

            <!-- Back link -->
            <a href="{{ route('home') }}" class="auth-back-link" wire:navigate>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Back to home
            </a>

            <!-- Glass card -->
            <div class="auth-glass-card">
                {{ $slot }}
            </div>

            <!-- Feature pills -->
            <div class="auth-features">
                <div class="auth-feature-pill">
                    <span>🎬</span>
                    <span>Video lessons</span>
                </div>
                <div class="auth-feature-pill">
                    <span>🎙️</span>
                    <span>Live classes</span>
                </div>
                <div class="auth-feature-pill">
                    <span>🎓</span>
                    <span>Certificates</span>
                </div>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </div>
</body>
</html>
