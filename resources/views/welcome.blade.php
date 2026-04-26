<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <style>
        /* ═══ PREMIUM GLASS UI — LANDING PAGE ═══ */

        /* Animated gradient mesh background */
        .glass-mesh-bg{position:fixed;inset:0;z-index:-1;overflow:hidden;background:var(--color-ivory)}
        .glass-mesh-bg::before,.glass-mesh-bg::after{content:'';position:absolute;border-radius:50%;filter:blur(100px);opacity:.35;animation:meshFloat 18s ease-in-out infinite alternate}
        .glass-mesh-bg::before{width:600px;height:600px;background:radial-gradient(circle,rgba(245,130,32,.4),transparent 70%);top:-10%;left:-5%}
        .glass-mesh-bg::after{width:500px;height:500px;background:radial-gradient(circle,rgba(248,249,250,.6),transparent 70%);bottom:-10%;right:-5%;animation-delay:-8s}
        .mesh-orb{position:absolute;border-radius:50%;filter:blur(90px);opacity:.25}
        .mesh-orb-1{width:400px;height:400px;background:radial-gradient(circle,rgba(245,130,32,.3),transparent 70%);top:40%;left:50%;animation:meshFloat 22s ease-in-out infinite alternate-reverse}
        .mesh-orb-2{width:350px;height:350px;background:radial-gradient(circle,rgba(255,220,180,.35),transparent 70%);top:20%;right:20%;animation:meshFloat 15s ease-in-out infinite alternate;animation-delay:-4s}
        @keyframes meshFloat{0%{transform:translate(0,0) scale(1)}33%{transform:translate(40px,-30px) scale(1.08)}66%{transform:translate(-30px,20px) scale(.95)}100%{transform:translate(20px,-10px) scale(1.05)}}

        .container{max-width:1200px;margin-left:auto;margin-right:auto;padding-left:1.5rem;padding-right:1.5rem}

        /* Sticky frosted navbar */
        .glass-nav{position:sticky;top:0;z-index:100;background:rgba(248,249,250,.65);backdrop-filter:blur(20px) saturate(1.4);-webkit-backdrop-filter:blur(20px) saturate(1.4);border-bottom:1px solid rgba(30,41,59,.05);transition:box-shadow .3s ease}
        .glass-nav.scrolled{box-shadow:0 4px 30px rgba(30,41,59,.08)}

        /* Hero */
        .hero{display:grid;grid-template-columns:1fr 480px;gap:3rem;align-items:center;min-height:75vh;padding:4rem 0 3rem}
        @media(max-width:1024px){.hero{grid-template-columns:1fr;min-height:auto;padding:3rem 0 2rem}}

        .kicker{display:inline-flex;align-items:center;gap:.5rem;font-size:.8rem;letter-spacing:.08em;text-transform:uppercase;color:var(--color-terra);font-weight:700;background:rgba(245,130,32,.08);padding:.35rem .85rem;border-radius:2rem;border:1px solid rgba(245,130,32,.15)}
        .hero-title{font-size:clamp(2.2rem,5vw,3.5rem);font-weight:800;line-height:1.1;color:var(--color-smoke);letter-spacing:-.02em}
        .hero-title .gradient-text{background:linear-gradient(135deg,var(--color-terra),#F58220);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}

        /* Premium CTA button with shimmer */
        .btn-premium{position:relative;display:inline-flex;align-items:center;justify-content:center;gap:.5rem;padding:.75rem 1.5rem;border-radius:.625rem;background:linear-gradient(135deg,var(--color-terra),#F58220);color:var(--color-ivory);font-weight:700;font-size:.95rem;border:none;box-shadow:0 8px 30px rgba(245,130,32,.25),0 2px 8px rgba(245,130,32,.12);overflow:hidden;transition:transform .2s ease,box-shadow .2s ease}
        .btn-premium:hover{transform:translateY(-2px);box-shadow:0 12px 40px rgba(245,130,32,.35),0 4px 12px rgba(245,130,32,.18)}
        .btn-premium::after{content:'';position:absolute;top:0;left:-100%;width:60%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.2),transparent);animation:shimmer 3s ease-in-out infinite}
        @keyframes shimmer{0%{left:-100%}50%{left:120%}100%{left:120%}}

        .btn-glass-outline{display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.25rem;border-radius:.625rem;background:rgba(255,255,255,.25);border:1px solid rgba(30,41,59,.1);color:var(--color-smoke);font-weight:600;font-size:.95rem;backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);transition:all .2s ease}
        .btn-glass-outline:hover{background:rgba(255,255,255,.45);border-color:rgba(30,41,59,.18);transform:translateY(-1px)}

        /* Hero visual floating badges */
        .hero-visual-wrap{position:relative}
        .hero-visual-wrap .glass-card{height:440px;overflow:hidden}
        .hero-float-badge{position:absolute;z-index:10;padding:.6rem 1rem;border-radius:.75rem;background:rgba(255,255,255,.7);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,.5);box-shadow:0 8px 25px rgba(30,41,59,.1);font-size:.85rem;font-weight:600;animation:floatBadge 6s ease-in-out infinite}
        .hero-float-badge.badge-1{top:8%;right:-8%;animation-delay:0s}
        .hero-float-badge.badge-2{bottom:12%;left:-6%;animation-delay:-2s}
        .hero-float-badge.badge-3{top:50%;right:-12%;animation-delay:-4s}
        @keyframes floatBadge{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}

        /* Stat pills */
        .stat-pill{padding:.5rem .85rem;border-radius:.5rem;background:rgba(255,255,255,.45);border:1px solid rgba(30,41,59,.06);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px)}
        .stat-pill .stat-value{font-weight:800;font-size:1.15rem;color:var(--color-smoke)}
        .stat-pill .stat-label{font-size:.75rem;color:rgba(30,41,59,.55)}

        /* Section reveal animation */
        .reveal{opacity:0;transform:translateY(30px);transition:opacity .7s cubic-bezier(.22,1,.36,1),transform .7s cubic-bezier(.22,1,.36,1)}
        .reveal.visible{opacity:1;transform:translateY(0)}

        .section-title{font-size:2rem;font-weight:800;color:var(--color-smoke);letter-spacing:-.01em}
        .section-subtitle{font-size:1.05rem;color:rgba(30,41,59,.65);max-width:560px}

        /* Feature grid */
        .feature-grid{display:grid;gap:1.25rem}
        @media(min-width:768px){.feature-grid{grid-template-columns:repeat(3,1fr)}}
        .feature-card{padding:1.75rem;border-radius:1rem;background:linear-gradient(180deg,rgba(255,255,255,.55),rgba(255,255,255,.25));border:1px solid rgba(30,41,59,.06);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);box-shadow:0 8px 30px rgba(30,41,59,.06);transition:transform .25s ease,box-shadow .25s ease}
        .feature-card:hover{transform:translateY(-4px);box-shadow:0 16px 45px rgba(30,41,59,.1)}
        .feature-icon{width:48px;height:48px;border-radius:.75rem;display:flex;align-items:center;justify-content:center;font-size:1.35rem;margin-bottom:1rem;background:linear-gradient(135deg,rgba(245,130,32,.12),rgba(245,130,32,.05));border:1px solid rgba(245,130,32,.12)}

        /* Course cards */
        .course-grid{display:grid;gap:1.25rem}
        @media(min-width:768px){.course-grid{grid-template-columns:repeat(3,1fr)}}
        .course-card{padding:1.75rem;border-radius:1rem;background:linear-gradient(180deg,rgba(255,255,255,.55),rgba(255,255,255,.25));border:1px solid rgba(30,41,59,.06);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);box-shadow:0 8px 30px rgba(30,41,59,.06);transition:transform .25s ease,box-shadow .25s ease;display:flex;flex-direction:column}
        .course-card:hover{transform:translateY(-4px);box-shadow:0 16px 45px rgba(30,41,59,.1)}
        .course-badge{display:inline-flex;padding:.25rem .65rem;border-radius:2rem;font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em}
        .course-badge.popular{background:rgba(245,130,32,.12);color:var(--color-terra);border:1px solid rgba(245,130,32,.18)}
        .course-badge.new-badge{background:rgba(34,197,94,.1);color:#16a34a;border:1px solid rgba(34,197,94,.18)}
        .course-badge.advanced{background:rgba(99,102,241,.1);color:#6366f1;border:1px solid rgba(99,102,241,.18)}
        .course-meta{display:flex;gap:1rem;font-size:.8rem;color:rgba(30,41,59,.55)}
        .course-price{font-size:1.5rem;font-weight:800;color:var(--color-smoke)}
        .course-price span{font-size:.85rem;font-weight:500;color:rgba(30,41,59,.55)}

        /* How it works steps */
        .step-card{display:flex;align-items:flex-start;gap:1.25rem;padding:1.5rem;border-radius:1rem;background:linear-gradient(180deg,rgba(255,255,255,.45),rgba(255,255,255,.2));border:1px solid rgba(30,41,59,.05);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);transition:transform .2s ease}
        .step-card:hover{transform:translateX(4px)}
        .step-number{width:48px;height:48px;border-radius:.75rem;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:1.15rem;background:linear-gradient(135deg,var(--color-terra),#F58220);color:var(--color-ivory);flex-shrink:0;box-shadow:0 4px 15px rgba(245,130,32,.25)}
        .step-connector{width:2px;height:24px;background:linear-gradient(180deg,rgba(245,130,32,.25),rgba(245,130,32,.05));margin-left:23px}

        /* Stats bar */
        .stats-bar{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;padding:2rem;border-radius:1rem;background:linear-gradient(135deg,rgba(255,255,255,.6),rgba(255,255,255,.3));border:1px solid rgba(30,41,59,.06);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);box-shadow:0 12px 40px rgba(30,41,59,.08)}
        @media(max-width:640px){.stats-bar{grid-template-columns:repeat(2,1fr)}}
        .stat-block{text-align:center;padding:.5rem}
        .stat-block .stat-number{font-size:2rem;font-weight:800;color:var(--color-smoke);line-height:1}
        .stat-block .stat-desc{font-size:.8rem;color:rgba(30,41,59,.55);margin-top:.25rem}

        /* Testimonials */
        .testimonial-card{padding:1.5rem;border-radius:1rem;background:linear-gradient(180deg,rgba(255,255,255,.55),rgba(255,255,255,.25));border:1px solid rgba(30,41,59,.06);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);box-shadow:0 8px 30px rgba(30,41,59,.06);transition:transform .25s ease}
        .testimonial-card:hover{transform:translateY(-3px)}
        .testimonial-stars{color:#f59e0b;font-size:.85rem;letter-spacing:.05em;margin-bottom:.5rem}
        .testimonial-avatar{width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;background:linear-gradient(135deg,rgba(245,130,32,.15),rgba(245,130,32,.05));border:1px solid rgba(245,130,32,.12);color:var(--color-terra)}

        /* Pricing cards */
        .pricing-card{padding:2rem;border-radius:1.25rem;background:linear-gradient(180deg,rgba(255,255,255,.5),rgba(255,255,255,.25));border:1px solid rgba(30,41,59,.06);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);box-shadow:0 8px 30px rgba(30,41,59,.06);transition:transform .25s ease,box-shadow .25s ease;display:flex;flex-direction:column}
        .pricing-card:hover{transform:translateY(-4px);box-shadow:0 16px 45px rgba(30,41,59,.1)}
        .pricing-card.featured{border-color:rgba(245,130,32,.2);box-shadow:0 12px 40px rgba(245,130,32,.12);background:linear-gradient(180deg,rgba(255,255,255,.65),rgba(255,255,255,.35));position:relative}
        .pricing-card.featured:hover{box-shadow:0 20px 55px rgba(245,130,32,.18)}
        .pricing-featured-badge{position:absolute;top:-12px;left:50%;transform:translateX(-50%);padding:.3rem 1rem;border-radius:2rem;background:linear-gradient(135deg,var(--color-terra),#F58220);color:var(--color-ivory);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;box-shadow:0 4px 15px rgba(245,130,32,.3)}
        .pricing-price{font-size:2.25rem;font-weight:800;color:var(--color-smoke)}
        .pricing-price span{font-size:.9rem;font-weight:500;color:rgba(30,41,59,.55)}
        .pricing-feature{display:flex;align-items:center;gap:.5rem;font-size:.875rem;color:rgba(30,41,59,.72);padding:.35rem 0}
        .pricing-check{width:18px;height:18px;border-radius:50%;background:rgba(34,197,94,.12);display:flex;align-items:center;justify-content:center;color:#16a34a;font-size:.65rem;flex-shrink:0}

        /* FAQ Accordion */
        .faq-item{border-radius:.75rem;background:rgba(255,255,255,.35);border:1px solid rgba(30,41,59,.06);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);overflow:hidden;transition:all .25s ease}
        .faq-item:hover{background:rgba(255,255,255,.5)}
        .faq-question{display:flex;align-items:center;justify-content:space-between;padding:1rem 1.25rem;cursor:pointer;font-weight:600;font-size:.95rem;color:var(--color-smoke);user-select:none}
        .faq-chevron{width:20px;height:20px;transition:transform .3s ease;color:rgba(30,41,59,.45)}
        .faq-item.open .faq-chevron{transform:rotate(180deg)}
        .faq-answer{max-height:0;overflow:hidden;transition:max-height .35s cubic-bezier(.22,1,.36,1),padding .35s ease;padding:0 1.25rem}
        .faq-item.open .faq-answer{max-height:200px;padding:0 1.25rem 1rem}
        .faq-answer p{font-size:.875rem;color:rgba(30,41,59,.65);line-height:1.6}

        /* Payment pills */
        .payment-pill{display:inline-flex;align-items:center;gap:.5rem;padding:.65rem 1.15rem;border-radius:.625rem;background:rgba(255,255,255,.45);border:1px solid rgba(30,41,59,.06);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);font-weight:600;font-size:.85rem;color:var(--color-smoke);transition:all .2s ease}
        .payment-pill:hover{background:rgba(255,255,255,.65);transform:translateY(-2px);box-shadow:0 6px 20px rgba(30,41,59,.08)}

        /* Live class card */
        .live-class-card{padding:2rem;border-radius:1.25rem;background:linear-gradient(135deg,rgba(245,130,32,.08),rgba(255,255,255,.45));border:1px solid rgba(245,130,32,.12);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);box-shadow:0 12px 40px rgba(30,41,59,.08)}
        .live-dot{width:10px;height:10px;border-radius:50%;background:#ef4444;animation:livePulse 2s ease-in-out infinite}
        @keyframes livePulse{0%,100%{opacity:1;box-shadow:0 0 0 0 rgba(239,68,68,.4)}50%{opacity:.7;box-shadow:0 0 0 8px rgba(239,68,68,0)}}

        /* Final CTA */
        .final-cta{padding:3rem;border-radius:1.5rem;background:linear-gradient(135deg,rgba(245,130,32,.1),rgba(255,255,255,.5));border:1px solid rgba(245,130,32,.12);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);box-shadow:0 16px 50px rgba(30,41,59,.1);text-align:center}

        /* Footer */
        .glass-footer{background:linear-gradient(180deg,rgba(248,249,250,.7),rgba(248,249,250,.9));backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);border-top:1px solid rgba(30,41,59,.05)}

        /* Problem cards */
        .problem-card{padding:1.25rem;border-radius:.75rem;background:rgba(255,255,255,.35);border:1px solid rgba(30,41,59,.06);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);transition:all .2s ease}
        .problem-card:hover{background:rgba(255,255,255,.55);border-color:rgba(239,68,68,.12)}
        .problem-icon{width:36px;height:36px;border-radius:.5rem;display:flex;align-items:center;justify-content:center;font-size:1rem;background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.1);color:#ef4444;flex-shrink:0}

        /* Benefit cards */
        .benefit-card{padding:1.5rem;border-radius:1rem;background:linear-gradient(180deg,rgba(255,255,255,.45),rgba(255,255,255,.2));border:1px solid rgba(30,41,59,.05);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);transition:transform .2s ease}
        .benefit-card:hover{transform:translateY(-3px)}
        .benefit-icon{width:40px;height:40px;border-radius:.625rem;display:flex;align-items:center;justify-content:center;font-size:1.15rem;margin-bottom:.75rem;background:linear-gradient(135deg,rgba(34,197,94,.1),rgba(34,197,94,.04));border:1px solid rgba(34,197,94,.1)}

        /* Mobile nav */
        .mobile-nav-toggle{display:none;background:rgba(255,255,255,.35);border:1px solid rgba(30,41,59,.08);border-radius:.5rem;padding:.5rem;cursor:pointer;color:var(--color-smoke);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px)}
        @media(max-width:768px){.mobile-nav-toggle{display:flex;align-items:center;justify-content:center}.nav-links{display:none}.nav-links.open{display:flex;flex-direction:column;position:absolute;top:100%;left:0;right:0;background:rgba(248,249,250,.92);backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);padding:1rem 1.5rem;border-bottom:1px solid rgba(30,41,59,.06);gap:.5rem}}

        /* Nav dropdown menus */
        .nav-dropdown{position:relative}
        .nav-dropdown-trigger{display:inline-flex;align-items:center;gap:.35rem;padding:.5rem .75rem;border-radius:.5rem;background:rgba(255,255,255,.2);border:1px solid rgba(30,41,59,.06);color:var(--color-smoke);font-weight:600;font-size:.875rem;cursor:pointer;transition:all .2s ease;backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px)}
        .nav-dropdown-trigger:hover{background:rgba(255,255,255,.4);border-color:rgba(30,41,59,.12)}
        .nav-dropdown-trigger svg{transition:transform .2s ease;opacity:.5}
        .nav-dropdown.open .nav-dropdown-trigger svg{transform:rotate(180deg)}
        .nav-dropdown-menu{position:absolute;top:calc(100% + 8px);left:50%;transform:translateX(-50%) translateY(8px);min-width:260px;padding:.5rem;border-radius:.875rem;background:rgba(255,255,255,.75);backdrop-filter:blur(24px) saturate(1.5);-webkit-backdrop-filter:blur(24px) saturate(1.5);border:1px solid rgba(30,41,59,.08);box-shadow:0 16px 48px rgba(30,41,59,.12),0 4px 12px rgba(30,41,59,.06);opacity:0;visibility:hidden;transition:opacity .25s ease,transform .25s ease,visibility .25s ease;z-index:200}
        .nav-dropdown.open .nav-dropdown-menu{opacity:1;visibility:visible;transform:translateX(-50%) translateY(0)}
        .nav-dropdown-item{display:flex;align-items:center;gap:.75rem;padding:.65rem .75rem;border-radius:.5rem;text-decoration:none;color:var(--color-smoke);transition:all .15s ease}
        .nav-dropdown-item:hover{background:rgba(245,130,32,.08)}
        .nav-dropdown-icon{width:36px;height:36px;border-radius:.5rem;display:flex;align-items:center;justify-content:center;font-size:1.1rem;background:linear-gradient(135deg,rgba(245,130,32,.1),rgba(245,130,32,.04));border:1px solid rgba(245,130,32,.1);flex-shrink:0}
        .nav-dropdown-item-title{font-weight:600;font-size:.85rem}
        .nav-dropdown-item-desc{font-size:.75rem;color:rgba(30,41,59,.5)}
    </style>
</head>
<body class="bg-[var(--color-ivory)] text-[var(--color-smoke)] antialiased leading-relaxed overflow-x-hidden">

    <!-- Animated gradient mesh background -->
    <div class="glass-mesh-bg" aria-hidden="true">
        <div class="mesh-orb mesh-orb-1"></div>
        <div class="mesh-orb mesh-orb-2"></div>
    </div>

    <!-- NAVBAR -->
    <header class="glass-nav" id="mainNav">
        <div class="container flex items-center justify-between py-3">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background:linear-gradient(135deg,var(--color-terra),#F58220); box-shadow:0 4px 12px rgba(245,130,32,.25);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden>
                        <path d="M7 13h10M7 9h10M7 17h6" stroke="var(--color-ivory)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <span class="font-bold text-lg tracking-tight">JackieEnglish</span>
            </a>

            <button class="mobile-nav-toggle" id="mobileNavToggle" aria-label="Toggle navigation">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>

            <nav class="nav-links flex items-center gap-1" id="navLinks">
                <!-- Features Dropdown -->
                <div class="nav-dropdown" id="dropdownFeatures">
                    <button class="nav-dropdown-trigger" onclick="toggleDropdown('dropdownFeatures')">
                        <span>Features</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div class="nav-dropdown-menu">
                        <a href="#features" class="nav-dropdown-item">
                            <div class="nav-dropdown-icon">🎬</div>
                            <div>
                                <div class="nav-dropdown-item-title">Video Lessons</div>
                                <div class="nav-dropdown-item-desc">Learn at your own pace</div>
                            </div>
                        </a>
                        <a href="#features" class="nav-dropdown-item">
                            <div class="nav-dropdown-icon">🎙️</div>
                            <div>
                                <div class="nav-dropdown-item-title">Live Classes</div>
                                <div class="nav-dropdown-item-desc">Practice speaking in real time</div>
                            </div>
                        </a>
                        <a href="#features" class="nav-dropdown-item">
                            <div class="nav-dropdown-icon">📊</div>
                            <div>
                                <div class="nav-dropdown-item-title">Progress Tracking</div>
                                <div class="nav-dropdown-item-desc">Stay motivated & accountable</div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Courses Dropdown -->
                <div class="nav-dropdown" id="dropdownCourses">
                    <button class="nav-dropdown-trigger" onclick="toggleDropdown('dropdownCourses')">
                        <span>Courses</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div class="nav-dropdown-menu">
                        @php
                            $navCourses = \App\Models\Course::where('status', \App\Enums\CourseStatus::Published)->orderByDesc('is_featured')->limit(4)->get();
                        @endphp
                        @foreach($navCourses as $navCourse)
                            <a href="#courses" class="nav-dropdown-item">
                                <div class="nav-dropdown-icon">{{ str_contains(strtolower($navCourse->title), 'spoken') ? '🗣️' : (str_contains(strtolower($navCourse->title), 'business') ? '💼' : (str_contains(strtolower($navCourse->title), 'ielts') ? '📝' : '📚')) }}</div>
                                <div>
                                    <div class="nav-dropdown-item-title">{{ $navCourse->title }}</div>
                                    <div class="nav-dropdown-item-desc">{{ $navCourse->duration_days }} weeks &bull; TSh {{ number_format($navCourse->price_amount, 0) }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Pricing Link -->
                <a href="#pricing" class="nav-dropdown-trigger" style="background:transparent; border:none; cursor:pointer;">Pricing</a>

                <div class="w-px h-6 bg-[rgba(30,41,59,0.1)] mx-2"></div>

                @auth
                    <a href="{{ route('dashboard') }}" class="btn-premium text-sm">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-glass-outline text-sm">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-premium text-sm">Get started</a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    <main>
        <!-- HERO -->
        <section class="container">
            <div class="hero">
                <div class="reveal">
                    <div class="kicker mb-5">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        Master English &bull; Speak Confidently
                    </div>

                    <h1 class="hero-title mb-5">
                        Learn English with<br>
                        <span class="gradient-text">Jackie</span> — Practice<br>
                        & Speak Confidently
                    </h1>

                    <p class="mb-7 text-lg leading-relaxed" style="color:rgba(30,41,59,.72); max-width:520px;">
                        Step-by-step video lessons, weekly live classes, interactive quizzes and certificates — all in one modern learning platform designed for busy learners in Tanzania. <strong style="color:var(--color-terra);">Start with a free trial!</strong>
                    </p>

                    <div class="flex flex-wrap gap-3 mb-8">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-premium">
                                Start Learning Now
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                        @endif
                        <a href="#courses" class="btn-glass-outline">View Courses</a>
                    </div>

                    @php
                        $totalStudents = \App\Models\User::where('role', 'student')->count();
                        $totalSubscriptions = \App\Models\Subscription::count();
                        $totalCourses = \App\Models\Course::where('status', \App\Enums\CourseStatus::Published)->count();
                    @endphp
                    <div class="flex flex-wrap gap-3">
                        <div class="stat-pill">
                            <div class="stat-value" data-count="{{ max($totalStudents, 500) }}">0</div>
                            <div class="stat-label">Students enrolled</div>
                        </div>
                        <div class="stat-pill">
                            <div class="stat-value" data-count="{{ max($totalSubscriptions, 300) }}">0</div>
                            <div class="stat-label">Active subscriptions</div>
                        </div>
                        <div class="stat-pill">
                            <div class="stat-value" data-count="{{ max($totalCourses, 4) }}">0</div>
                            <div class="stat-label">Courses available</div>
                        </div>
                    </div>
                </div>

                <div class="hero-visual-wrap reveal" style="transition-delay:.15s">
                    <div class="glass-card glass-elevated p-3" style="border-radius:1.25rem;">
                        <div style="border-radius:1rem; width:100%; height:100%; min-height:420px; position:relative; overflow:hidden; background:linear-gradient(135deg, #f5a623 0%, #d4831a 50%, #bc6f15 100%);">
                            <img src="https://images.unsplash.com/photo-1522202176212-a2994003db40?w=800&q=80"
                                 alt="Student learning English online"
                                 style="border-radius:1rem; width:100%; height:100%; object-fit:cover; display:block; opacity:0; transition:opacity .5s ease;"
                                 loading="lazy"
                                 onload="this.style.opacity=1"
                                 onerror="this.style.display='none'" />
                            <div style="position:absolute; inset:0; background:linear-gradient(180deg, rgba(40,36,39,.15) 0%, rgba(40,36,39,.45) 100%); border-radius:1rem;"></div>
                            <div style="position:absolute; bottom:1.5rem; left:1.5rem; right:1.5rem; z-index:2;">
                                <div style="padding:1rem 1.25rem; border-radius:.75rem; background:rgba(255,255,255,.85); backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); border:1px solid rgba(255,255,255,.5); box-shadow:0 8px 25px rgba(0,0,0,.12);">
                                    <div style="display:flex; align-items:center; gap:.5rem; margin-bottom:.35rem;">
                                        <div style="width:8px; height:8px; border-radius:50%; background:#22c55e;"></div>
                                        <span style="font-size:.75rem; font-weight:700; color:#16a34a; text-transform:uppercase; letter-spacing:.05em;">Live Now</span>
                                    </div>
                                    <div style="font-size:.95rem; font-weight:700; color:var(--color-smoke);">Interactive English Class</div>
                                    <div style="font-size:.8rem; color:rgba(30,41,59,.6); margin-top:.15rem;">Join 500+ students learning online</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating badges -->
                    <div class="hero-float-badge badge-1">
                        <span style="color:#16a34a;">&#10003;</span> Course Completed
                    </div>
                    <div class="hero-float-badge badge-2">
                        <span style="color:var(--color-terra);">&#9733;</span> 4.9 Rating
                    </div>
                    <div class="hero-float-badge badge-3">
                        <span style="color:#6366f1;">&#9655;</span> Live Class
                    </div>
                </div>
            </div>
        </section>

        <!-- PROBLEM -->
        <section class="container py-16 reveal">
            <div class="text-center mb-8">
                <h2 class="section-title mb-2">Common challenges</h2>
                <p class="section-subtitle mx-auto">If you've struggled with these, you're not alone.</p>
            </div>
            <div class="grid gap-4 md:grid-cols-3">
                <div class="problem-card flex items-start gap-3">
                    <div class="problem-icon">😰</div>
                    <div>
                        <strong class="text-sm">Speaking anxiety</strong>
                        <div class="text-sm text-[rgba(30,41,59,0.6)] mt-1">You know grammar but freeze when asked to speak in real life.</div>
                    </div>
                </div>
                <div class="problem-card flex items-start gap-3">
                    <div class="problem-icon">🧩</div>
                    <div>
                        <strong class="text-sm">Unstructured content</strong>
                        <div class="text-sm text-[rgba(30,41,59,0.6)] mt-1">Courses are scattered across platforms; progress is hard to track.</div>
                    </div>
                </div>
                <div class="problem-card flex items-start gap-3">
                    <div class="problem-icon">💳</div>
                    <div>
                        <strong class="text-sm">Payment confusion</strong>
                        <div class="text-sm text-[rgba(30,41,59,0.6)] mt-1">Unclear payment and access processes lead to drop-offs.</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FEATURES -->
        <section id="features" class="container py-16 reveal">
            <div class="text-center mb-8">
                <h2 class="section-title mb-2">Why JackieEnglish works</h2>
                <p class="section-subtitle mx-auto">A learning experience designed around your needs.</p>
            </div>
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">🎬</div>
                    <h3 class="font-bold mb-2">Video lessons anytime</h3>
                    <p class="text-sm text-[rgba(30,41,59,0.65)]">Short, practical lessons you can watch on your phone. Low-data options included.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎙️</div>
                    <h3 class="font-bold mb-2">Live classes & feedback</h3>
                    <p class="text-sm text-[rgba(30,41,59,0.65)]">Weekly live sessions to practice speaking and ask questions in real time.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3 class="font-bold mb-2">Quizzes & progress tracking</h3>
                    <p class="text-sm text-[rgba(30,41,59,0.65)]">Automated quizzes and progress reports keep you motivated and accountable.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎓</div>
                    <h3 class="font-bold mb-2">Certificates on completion</h3>
                    <p class="text-sm text-[rgba(30,41,59,0.65)]">Earn verified certificates when you complete course requirements.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3 class="font-bold mb-2">Mobile-first design</h3>
                    <p class="text-sm text-[rgba(30,41,59,0.65)]">Learn on any device — no app install needed. Fully responsive experience.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h3 class="font-bold mb-2">Instant access after payment</h3>
                    <p class="text-sm text-[rgba(30,41,59,0.65)]">Mobile money payments trigger automatic enrollment — no waiting.</p>
                </div>
            </div>
        </section>

        <!-- COURSES -->
        <section id="courses" class="container py-16 reveal">
            <div class="text-center mb-8">
                <h2 class="section-title mb-2">Featured courses</h2>
                <p class="section-subtitle mx-auto">Choose the track that matches your goals.</p>
            </div>
            <div class="course-grid">
                @php
                    $courses = \App\Models\Course::where('status', \App\Enums\CourseStatus::Published)->orderByDesc('is_featured')->limit(6)->get();
                @endphp
                @forelse($courses as $course)
                    <div class="course-card">
                        @php
                            $courseImages = [
                                'spoken' => ['url' => 'https://images.unsplash.com/photo-1543165796-5426273eaab3?w=600&q=80', 'bg' => '#e8975a'],
                                'business' => ['url' => 'https://images.unsplash.com/photo-1552664733-d6d7a8a4345?w=600&q=80', 'bg' => '#5a8ee8'],
                                'ielts' => ['url' => 'https://images.unsplash.com/photo-1456511780578-1a7e62e0c3c5?w=600&q=80', 'bg' => '#7c5ae8'],
                                'default' => ['url' => 'https://images.unsplash.com/photo-1509062523349-8427d3e7e577?w=600&q=80', 'bg' => '#5abce8'],
                            ];
                            $courseImg = str_contains(strtolower($course->title), 'spoken') ? $courseImages['spoken']
                                : (str_contains(strtolower($course->title), 'business') ? $courseImages['business']
                                : (str_contains(strtolower($course->title), 'ielts') ? $courseImages['ielts']
                                : $courseImages['default']));
                        @endphp
                        <div style="border-radius:.75rem; overflow:hidden; margin-bottom:1rem; height:160px; background:{{ $courseImg['bg'] }};">
                            <img src="{{ $courseImg['url'] }}" alt="{{ $course->title }}" style="width:100%; height:100%; object-fit:cover; display:block; opacity:0; transition:opacity .5s ease;" loading="lazy" onload="this.style.opacity=1" onerror="this.style.display='none'" />
                        </div>
                        <div class="mb-3">
                            @if($course->is_featured)
                                <span class="course-badge popular">Popular</span>
                            @endif
                            @if($course->has_free_trial)
                                <span class="course-badge new-badge">{{ $course->free_trial_days }}-Day Free Trial</span>
                            @endif
                        </div>
                        <h3 class="font-bold text-lg mb-1">{{ $course->title }}</h3>
                        <p class="text-sm text-[rgba(30,41,59,0.6)] mb-4">{{ $course->excerpt ?? 'Improve your English skills with structured lessons.' }}</p>
                        <div class="course-meta mb-4">
                            <span>{{ $course->duration_days }} days</span><span>&bull;</span><span>{{ $course->lessons()->count() }} lessons</span>
                        </div>
                        <div class="mt-auto">
                            <div class="course-price mb-3">{{ $course->currency }} {{ number_format($course->price_amount, 0) }} <span>/course</span></div>
                            @auth
                                <a href="{{ route('student.catalog') }}" class="btn-premium w-full text-center text-sm">
                                    @if($course->has_free_trial)
                                        Start Free Trial
                                    @else
                                        Enroll Now
                                    @endif
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="btn-premium w-full text-center text-sm">
                                    @if($course->has_free_trial)
                                        Start Free Trial
                                    @else
                                        Enroll Now
                                    @endif
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="course-card" style="grid-column:1/-1; text-align:center; padding:3rem;">
                        <p class="text-[rgba(30,41,59,0.5)]">Courses coming soon. Register to get notified!</p>
                        <a href="{{ route('register') }}" class="btn-premium text-sm mt-4">Register Now</a>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- HOW IT WORKS -->
        <section class="container py-16 reveal">
            <div class="text-center mb-8">
                <h2 class="section-title mb-2">How it works</h2>
                <p class="section-subtitle mx-auto">Three simple steps to start your journey.</p>
            </div>
            <div class="max-w-xl mx-auto">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div>
                        <strong class="text-base">Choose a course</strong>
                        <div class="text-sm text-[rgba(30,41,59,0.6)] mt-1">Pick the track that matches your goals and schedule.</div>
                    </div>
                </div>
                <div class="step-connector"></div>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div>
                        <strong class="text-base">Register & pay</strong>
                        <div class="text-sm text-[rgba(30,41,59,0.6)] mt-1">Pay securely via mobile money — access opens automatically.</div>
                    </div>
                </div>
                <div class="step-connector"></div>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div>
                        <strong class="text-base">Start learning</strong>
                        <div class="text-sm text-[rgba(30,41,59,0.6)] mt-1">Watch lessons, attend live classes and complete quizzes to progress.</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- STATS -->
        <section class="container py-12 reveal">
            @php
                $statStudents = \App\Models\User::where('role', 'student')->count();
                $statLiveClasses = \App\Models\LiveClass::count();
                $statCourses = \App\Models\Course::where('status', \App\Enums\CourseStatus::Published)->count();
                $statSubscriptions = \App\Models\Subscription::count();
            @endphp
            <div class="stats-bar">
                <div class="stat-block">
                    <div class="stat-number" data-count="{{ max($statStudents, 500) }}">0+</div>
                    <div class="stat-desc">Students enrolled</div>
                </div>
                <div class="stat-block">
                    <div class="stat-number" data-count="{{ max($statLiveClasses, 20) }}">0+</div>
                    <div class="stat-desc">Live classes held</div>
                </div>
                <div class="stat-block">
                    <div class="stat-number">95%</div>
                    <div class="stat-desc">Satisfaction rate</div>
                </div>
                <div class="stat-block">
                    <div class="stat-number" data-count="{{ max($statCourses, 4) }}">0+</div>
                    <div class="stat-desc">Courses available</div>
                </div>
            </div>
        </section>

        <!-- TESTIMONIALS -->
        <section class="container py-16 reveal">
            <div class="text-center mb-8">
                <h2 class="section-title mb-2">What students say</h2>
                <p class="section-subtitle mx-auto">Real stories from real learners.</p>
            </div>
            <div class="grid gap-5 md:grid-cols-3">
                <div class="testimonial-card">
                    <div class="testimonial-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                    <p class="text-sm text-[rgba(30,41,59,0.7)] mb-4 leading-relaxed">"I used to be shy speaking — after weekly live classes I now participate confidently in meetings."</p>
                    <div class="flex items-center gap-3">
                        <div class="testimonial-avatar">AH</div>
                        <div>
                            <div class="font-semibold text-sm">Amina Hassan</div>
                            <div class="text-xs text-[rgba(30,41,59,0.5)]">Spoken English</div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                    <p class="text-sm text-[rgba(30,41,59,0.7)] mb-4 leading-relaxed">"Clear lessons and practical tasks — my writing improved fast. The structure kept me on track."</p>
                    <div class="flex items-center gap-3">
                        <div class="testimonial-avatar">BM</div>
                        <div>
                            <div class="font-semibold text-sm">Ben Mwakyembe</div>
                            <div class="text-xs text-[rgba(30,41,59,0.5)]">Business English</div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                    <p class="text-sm text-[rgba(30,41,59,0.7)] mb-4 leading-relaxed">"Easy payments and instant access — exactly what I needed as a working professional."</p>
                    <div class="flex items-center gap-3">
                        <div class="testimonial-avatar">CS</div>
                        <div>
                            <div class="font-semibold text-sm">Cecilia S.</div>
                            <div class="text-xs text-[rgba(30,41,59,0.5)]">IELTS Preparation</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- LIVE CLASS -->
        <section class="container py-12 reveal">
            @php
                $nextLiveClass = \App\Models\LiveClass::where('scheduled_at', '>', now())
                    ->orWhere('status', \App\Enums\LiveClassStatus::Live)
                    ->with('course')
                    ->orderByRaw("CASE WHEN status = 'live' THEN 0 ELSE 1 END")
                    ->orderBy('scheduled_at')
                    ->first();
            @endphp
            @if($nextLiveClass)
                <div class="live-class-card flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            @if($nextLiveClass->status->value === 'live')
                                <div class="live-dot"></div>
                                <span class="text-xs font-bold text-red-500 uppercase tracking-wider">Live Now</span>
                            @else
                                <div style="width:10px;height:10px;border-radius:50%;background:var(--color-terra);"></div>
                                <span class="text-xs font-bold uppercase tracking-wider" style="color:var(--color-terra);">Next session</span>
                            @endif
                        </div>
                        <div class="font-bold text-lg">{{ $nextLiveClass->title }}</div>
                        <div class="text-sm text-[rgba(30,41,59,0.6)] mt-1">
                            {{ $nextLiveClass->course?->title }} &bull;
                            @if($nextLiveClass->status->value === 'live')
                                Happening now &bull; Join on platform
                            @else
                                {{ $nextLiveClass->scheduled_at->format('D, M j \a\t h:i A') }} &bull; Live on platform
                            @endif
                        </div>
                    </div>
                    <div>
                        @auth
                            <a href="{{ route('student.live-classes') }}" class="btn-premium">
                                @if($nextLiveClass->status->value === 'live')
                                    Join Live Class
                                @else
                                    Set Reminder
                                @endif
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn-premium">Register to Attend</a>
                        @endif
                    </div>
                </div>
            @else
                <div class="live-class-card flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <div style="width:10px;height:10px;border-radius:50%;background:var(--color-terra);"></div>
                            <span class="text-xs font-bold uppercase tracking-wider" style="color:var(--color-terra);">Live classes</span>
                        </div>
                        <div class="font-bold text-lg">Weekly live speaking practice</div>
                        <div class="text-sm text-[rgba(30,41,59,0.6)] mt-1">Enroll in a course to join live sessions with real-time feedback.</div>
                    </div>
                    <div>
                        <a href="{{ route('register') }}" class="btn-premium">Get Started</a>
                    </div>
                </div>
            @endif
        </section>

        <!-- BENEFITS -->
        <section class="container py-16 reveal">
            <div class="text-center mb-8">
                <h2 class="section-title mb-2">Built for you</h2>
                <p class="section-subtitle mx-auto">Every detail is designed around the Tanzanian learner.</p>
            </div>
            <div class="feature-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">🌐</div>
                    <h4 class="font-bold mb-1">Learn anywhere</h4>
                    <p class="text-sm text-[rgba(30,41,59,0.6)]">Browser-based learning — no install required. Optimized for mobile.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">📶</div>
                    <h4 class="font-bold mb-1">Low data mode</h4>
                    <p class="text-sm text-[rgba(30,41,59,0.6)]">Videos and materials optimized to save your data.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">⚡</div>
                    <h4 class="font-bold mb-1">Automatic access</h4>
                    <p class="text-sm text-[rgba(30,41,59,0.6)]">Payments trigger subscriptions automatically — no manual approvals.</p>
                </div>
            </div>
        </section>

        <!-- PAYMENTS -->
        <section class="container py-12 reveal">
            <div class="text-center mb-6">
                <h2 class="section-title mb-2">Payment methods</h2>
                <p class="section-subtitle mx-auto">Pay securely using mobile money. Access opens automatically.</p>
            </div>
            <div class="flex flex-wrap gap-3 justify-center">
                <div class="payment-pill">📱 M-Pesa</div>
                <div class="payment-pill">📱 Airtel Money</div>
                <div class="payment-pill">📱 Tigo Pesa</div>
                <div class="payment-pill">💳 Visa / Mastercard</div>
            </div>
        </section>

        <!-- PRICING -->
        <section id="pricing" class="container py-16 reveal">
            <div class="text-center mb-8">
                <h2 class="section-title mb-2">Pricing & plans</h2>
                <p class="section-subtitle mx-auto">Affordable plans that give you real results.</p>
            </div>
            <div class="grid gap-5 md:grid-cols-3 items-start">
                @forelse($courses as $index => $course)
                    <div class="pricing-card {{ $course->is_featured ? 'featured' : '' }}">
                        @if($course->is_featured)
                            <div class="pricing-featured-badge">Best Value</div>
                        @endif
                        @php
                            $pricingImages = [
                                'spoken' => ['url' => 'https://images.unsplash.com/photo-1543165796-5426273eaab3?w=600&q=80', 'bg' => '#e8975a'],
                                'business' => ['url' => 'https://images.unsplash.com/photo-1552664733-d6d7a8a4345?w=600&q=80', 'bg' => '#5a8ee8'],
                                'ielts' => ['url' => 'https://images.unsplash.com/photo-1456511780578-1a7e62e0c3c5?w=600&q=80', 'bg' => '#7c5ae8'],
                                'default' => ['url' => 'https://images.unsplash.com/photo-1509062523349-8427d3e7e577?w=600&q=80', 'bg' => '#5abce8'],
                            ];
                            $pricingImg = str_contains(strtolower($course->title), 'spoken') ? $pricingImages['spoken']
                                : (str_contains(strtolower($course->title), 'business') ? $pricingImages['business']
                                : (str_contains(strtolower($course->title), 'ielts') ? $pricingImages['ielts']
                                : $pricingImages['default']));
                        @endphp
                        <div style="border-radius:.75rem; overflow:hidden; margin-bottom:1.25rem; height:140px; background:{{ $pricingImg['bg'] }};">
                            <img src="{{ $pricingImg['url'] }}" alt="{{ $course->title }}" style="width:100%; height:100%; object-fit:cover; display:block; opacity:0; transition:opacity .5s ease;" loading="lazy" onload="this.style.opacity=1" onerror="this.style.display='none'" />
                        </div>
                        <div class="font-bold text-lg mb-1">{{ $course->title }}</div>
                        <p class="text-sm text-[rgba(30,41,59,0.55)] mb-4">{{ $course->excerpt ?? 'Improve your English with structured lessons.' }}</p>
                        <div class="pricing-price mb-4">{{ $course->currency }} {{ number_format($course->price_amount, 0) }} <span>/course</span></div>
                        @if($course->has_free_trial)
                            <div class="mb-3 text-sm font-semibold" style="color: #16a34a;">
                                🎁 {{ $course->free_trial_days }}-day free trial included
                            </div>
                        @endif
                        <div class="mb-5">
                            <div class="pricing-feature"><div class="pricing-check">&#10003;</div> {{ $course->duration_days }} days access</div>
                            <div class="pricing-feature"><div class="pricing-check">&#10003;</div> {{ $course->lessons()->count() }} video lessons</div>
                            <div class="pricing-feature"><div class="pricing-check">&#10003;</div> Quizzes & tracking</div>
                            @if($course->is_featured)
                                <div class="pricing-feature"><div class="pricing-check">&#10003;</div> Live class access</div>
                                <div class="pricing-feature"><div class="pricing-check">&#10003;</div> Certificate</div>
                            @endif
                        </div>
                        @auth
                            <a href="{{ route('student.catalog') }}" class="{{ $course->is_featured ? 'btn-premium' : 'btn-glass-outline' }} w-full text-center">
                                @if($course->has_free_trial)
                                    Start Free Trial
                                @else
                                    Enroll Now
                                @endif
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="{{ $course->is_featured ? 'btn-premium' : 'btn-glass-outline' }} w-full text-center">
                                @if($course->has_free_trial)
                                    Start Free Trial
                                @else
                                    Get Started
                                @endif
                            </a>
                        @endif
                    </div>
                @empty
                    <div class="pricing-card" style="grid-column:1/-1; text-align:center; padding:3rem;">
                        <p class="text-[rgba(30,41,59,0.5)]">Plans coming soon. Register to get notified!</p>
                        <a href="{{ route('register') }}" class="btn-premium text-sm mt-4">Register Now</a>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- FAQ -->
        <section class="container py-16 reveal">
            <div class="text-center mb-8">
                <h2 class="section-title mb-2">Frequently asked questions</h2>
                <p class="section-subtitle mx-auto">Everything you need to know before you start.</p>
            </div>
            <div class="max-w-2xl mx-auto grid gap-3">
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Do I need to install an app?</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="faq-answer">
                        <p>No — JackieEnglish runs in your browser on phone or desktop. Just visit the website and start learning.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>When will I get access after payment?</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="faq-answer">
                        <p>Access is granted automatically once payment is confirmed via webhook. Usually within minutes.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Can I attend live classes?</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="faq-answer">
                        <p>Yes — enroll in a course and join scheduled live sessions directly on the platform.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Do you provide certificates?</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="faq-answer">
                        <p>Yes — complete the course requirements to earn a verified certificate that you can share.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>What if I need help during the course?</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="faq-answer">
                        <p>You can ask questions during live classes, or reach out via the support chat. Premium Bundle users get priority support.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Is there a free trial?</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="faq-answer">
                        <p>Yes! Many of our courses offer a free trial period so you can explore lessons before committing. Just register and start your trial — no payment required upfront.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FINAL CTA -->
        <section class="container py-16 reveal">
            <div class="final-cta">
                <h2 class="section-title mb-3">Ready to speak English with confidence?</h2>
                <p class="section-subtitle mx-auto mb-6">Start your learning journey today and join {{ max($totalStudents, 500) }}+ students already seeing results.</p>
                <div class="flex flex-wrap gap-3 justify-center">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-premium">
                            Start Learning Now
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    @endif
                    <a href="#courses" class="btn-glass-outline">Explore Courses</a>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="glass-footer">
        <div class="container py-10">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2.5 mb-2">
                        <div class="w-7 h-7 rounded-md flex items-center justify-center" style="background:linear-gradient(135deg,var(--color-terra),#F58220);">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden>
                                <path d="M7 13h10M7 9h10M7 17h6" stroke="var(--color-ivory)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span class="font-bold">JackieEnglish</span>
                    </div>
                    <div class="text-sm text-[rgba(30,41,59,0.55)]">Premium online English learning tailored for Tanzania.</div>
                </div>
                <div class="flex gap-5 items-center">
                    <a href="#" class="text-sm text-[rgba(30,41,59,0.6)] hover:text-(--color-smoke) transition-colors">Contact</a>
                    <a href="#" class="text-sm text-[rgba(30,41,59,0.6)] hover:text-(--color-smoke) transition-colors">Privacy</a>
                    <a href="#" class="text-sm text-[rgba(30,41,59,0.6)] hover:text-(--color-smoke) transition-colors">Terms</a>
                </div>
            </div>
            <div class="mt-6 text-sm text-[rgba(30,41,59,0.45)]">
                &copy; {{ date('Y') }} {{ config('app.name', 'JackieEnglish') }}. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // Dropdown toggle
        function toggleDropdown(id) {
            const el = document.getElementById(id);
            const isOpen = el.classList.contains('open');
            // Close all dropdowns first
            document.querySelectorAll('.nav-dropdown').forEach(d => d.classList.remove('open'));
            if (!isOpen) el.classList.add('open');
        }
        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.nav-dropdown')) {
                document.querySelectorAll('.nav-dropdown').forEach(d => d.classList.remove('open'));
            }
        });

        // FAQ accordion
        function toggleFaq(el) {
            const item = el.closest('.faq-item');
            item.classList.toggle('open');
        }

        // Scroll reveal
        const revealEls = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });
        revealEls.forEach(el => revealObserver.observe(el));

        // Navbar scroll shadow
        const nav = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 20);
        });

        // Mobile nav toggle
        const mobileToggle = document.getElementById('mobileNavToggle');
        const navLinks = document.getElementById('navLinks');
        mobileToggle?.addEventListener('click', () => {
            navLinks.classList.toggle('open');
        });

        // Counter animation
        function animateCounters() {
            document.querySelectorAll('[data-count]').forEach(el => {
                const target = parseInt(el.dataset.count);
                const suffix = el.textContent.replace(/[0-9]/g, '');
                let current = 0;
                const step = Math.max(1, Math.floor(target / 40));
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    el.textContent = current + suffix;
                }, 30);
            });
        }
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    counterObserver.disconnect();
                }
            });
        }, { threshold: 0.3 });
        document.querySelectorAll('.stats-bar').forEach(el => counterObserver.observe(el));
        document.querySelectorAll('.stat-pill').forEach(el => {
            const countEl = el.querySelector('[data-count]');
            if (countEl) {
                const pillObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const target = parseInt(countEl.dataset.count);
                            const suffix = countEl.textContent.replace(/[0-9]/g, '');
                            let current = 0;
                            const step = Math.max(1, Math.floor(target / 40));
                            const timer = setInterval(() => {
                                current += step;
                                if (current >= target) { current = target; clearInterval(timer); }
                                countEl.textContent = current + suffix;
                            }, 30);
                            pillObserver.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.5 });
                pillObserver.observe(el);
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', (e) => {
                const target = document.querySelector(a.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    // Close mobile nav if open
                    navLinks?.classList.remove('open');
                }
            });
        });
    </script>

    @fluxScripts
</body>
</html>
