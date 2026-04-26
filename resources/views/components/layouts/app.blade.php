<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <title>{{ $title ?? 'Jackie LMS' }}</title>
    <style>
        body { display: flex; min-height: 100vh; }
        .app-container { display: flex; width: 100%; }

        .app-sidebar {
            width: 220px;
            background: linear-gradient(180deg, rgba(255,255,255,.92), rgba(248,249,250,.88));
            backdrop-filter: blur(12px);
            border-right: 1px solid rgba(30,41,59,.06);
            display: flex;
            flex-direction: column;
            transition: width .3s cubic-bezier(.4,0,.2,1), transform .3s ease;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 100;
            flex-shrink: 0;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .app-sidebar::-webkit-scrollbar {
            width: 0;
            height: 0;
            display: none;
        }

        /* Main content offset for fixed sidebar */
        .app-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: var(--color-ivory);
            margin-left: 220px;
            min-height: 100vh;
            transition: margin-left .3s cubic-bezier(.4,0,.2,1);
        }

        /* Adjust main content when sidebar is collapsed */
        .app-sidebar.collapsed ~ .app-main,
        .app-sidebar.collapsed + * + .app-main {
            margin-left: 56px;
        }

        /* Collapsed sidebar state */
        .app-sidebar.collapsed {
            width: 56px;
        }

        /* Sidebar nav - no scroll, compact */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding: .5rem 0;
        }

        .sidebar-nav::-webkit-scrollbar {
            display: none;
        }

        .app-sidebar.collapsed .sidebar-brand span,
        .app-sidebar.collapsed .nav-section-title,
        .app-sidebar.collapsed .nav-item span:not(.nav-icon),
        .app-sidebar.collapsed .nav-badge,
        .app-sidebar.collapsed .user-info {
            opacity: 0;
            width: 0;
            overflow: hidden;
            white-space: nowrap;
        }

        .app-sidebar.collapsed .nav-item {
            justify-content: center;
            padding: .5rem;
            margin: .125rem auto;
            min-height: 36px;
            width: 36px;
            align-self: center;
        }

        .app-sidebar.collapsed .nav-icon {
            margin: 0;
            width: 20px;
            height: 20px;
            font-size: 1.125rem;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Ensure text is fully hidden in collapsed mode */
        .app-sidebar.collapsed .nav-item > span:not(.nav-icon) {
            display: none !important;
        }

        /* Fix badges in collapsed mode */
        .app-sidebar.collapsed .nav-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            font-size: .625rem;
            padding: 1px 4px;
            min-width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Tooltip for collapsed items */
        .app-sidebar.collapsed .nav-item {
            position: relative;
        }

        .app-sidebar.collapsed .nav-item:hover::after {
            content: attr(data-title);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: var(--color-smoke);
            color: var(--color-ivory);
            padding: .5rem .75rem;
            border-radius: .5rem;
            font-size: .875rem;
            white-space: nowrap;
            margin-left: .75rem;
            z-index: 200;
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(30,41,59,.15);
        }

        .app-sidebar.collapsed .nav-item:hover::before {
            content: '';
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 6px solid transparent;
            border-right-color: var(--color-smoke);
            margin-left: -.25rem;
            z-index: 200;
        }

        .app-sidebar.collapsed .sidebar-header {
            justify-content: center;
        }

        .app-sidebar.collapsed .sidebar-brand {
            gap: 0;
        }

        .app-sidebar.collapsed .sidebar-user {
            justify-content: center;
            padding: .75rem;
        }

        .app-sidebar.collapsed .user-avatar {
            width: 36px;
            height: 36px;
            font-size: .75rem;
        }

        /* Collapsed section dividers */
        .app-sidebar.collapsed .nav-section {
            padding: .375rem .5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-bottom: none;
        }

        .app-sidebar.collapsed .nav-section:last-child {
            border-bottom: none;
        }

        .app-sidebar.collapsed .nav-section-title {
            display: none;
        }

        /* Add small gap between sections in collapsed mode */
        .app-sidebar.collapsed .nav-section + .nav-section {
            margin-top: .5rem;
            padding-top: .5rem;
            border-top: 1px solid rgba(30,41,59,.06);
        }

        /* Smart toggle button */
        .sidebar-smart-toggle {
            position: absolute;
            right: -12px;
            top: 24px;
            width: 24px;
            height: 24px;
            background: white;
            border: 1px solid rgba(30,41,59,.12);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 101;
            box-shadow: 0 2px 8px rgba(30,41,59,.1);
            transition: all .2s ease;
        }

        .sidebar-smart-toggle:hover {
            background: var(--color-terra);
            border-color: var(--color-terra);
            color: white;
            transform: scale(1.1);
        }

        .app-sidebar.collapsed .sidebar-smart-toggle {
            right: -12px;
            transform: rotate(180deg);
        }

        .app-sidebar.collapsed .sidebar-smart-toggle:hover {
            transform: rotate(180deg) scale(1.1);
        }

        /* Mobile styles */
        .app-sidebar.mobile-hidden {
            display: none;
        }

        @media (max-width: 768px) {
            .app-sidebar {
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                box-shadow: 4px 0 20px rgba(30,41,59,.15);
                margin-left: 0;
            }
            
            .app-main {
                margin-left: 0;
            }
            .app-sidebar.mobile-hidden { display: none; }
            .app-sidebar.mobile-open { display: flex; }
            
            /* Disable collapsed state on mobile */
            .app-sidebar.collapsed {
                width: 64px;
            }
            
            .app-sidebar.collapsed .nav-item > span:not(.nav-icon) {
                display: none !important;
            }
            
            .sidebar-smart-toggle {
                display: none;
            }
        }

        .sidebar-header {
            padding: 1rem;
            border-bottom: 1px solid rgba(30,41,59,.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .5rem;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            text-decoration: none;
            font-weight: 600;
            color: var(--color-smoke);
            font-size: 1.125rem;
        }

        .sidebar-toggle-btn {
            display: none;
            background: transparent;
            border: 1px solid rgba(30,41,59,.12);
            padding: .5rem;
            border-radius: .5rem;
            cursor: pointer;
            color: var(--color-smoke);
        }

        @media (max-width: 768px) {
            .sidebar-toggle-btn { display: flex; align-items: center; justify-content: center; }
        }

        .nav-section {
            padding: 0 .5rem .5rem;
            border-bottom: 1px solid rgba(30,41,59,.04);
        }

        .nav-section:last-child { border-bottom: none; }

        .nav-section-title {
            font-size: .625rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: rgba(30,41,59,.4);
            font-weight: 700;
            padding: .375rem .625rem;
            margin-bottom: .25rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: .625rem;
            padding: .5rem .625rem;
            margin-bottom: .125rem;
            border-radius: .5rem;
            color: rgba(30,41,59,.72);
            text-decoration: none;
            font-size: .8125rem;
            font-weight: 500;
            transition: all .2s ease;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .nav-item:hover {
            background: rgba(245,130,32,.08);
            color: var(--color-smoke);
        }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(245,130,32,.12), rgba(245,130,32,.06));
            color: var(--color-terra);
            border-color: rgba(245,130,32,.2);
            font-weight: 600;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            line-height: 1;
            font-size: 1rem;
        }

        .nav-badge {
            margin-left: auto;
            background: var(--color-terra);
            color: var(--color-ivory);
            font-size: .625rem;
            padding: .125rem .375rem;
            border-radius: .25rem;
            font-weight: 600;
        }

        .sidebar-user {
            padding: .75rem;
            border-top: 1px solid rgba(30,41,59,.06);
            display: flex;
            align-items: center;
            gap: .625rem;
            cursor: pointer;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: .375rem;
            background: var(--color-terra);
            color: var(--color-ivory);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: .75rem;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-weight: 600;
            color: var(--color-smoke);
            font-size: .8125rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: .6875rem;
            color: rgba(30,41,59,.5);
            text-transform: capitalize;
        }

        /* Main content area - now with margin for fixed sidebar */
        .app-content-area {
            flex: 1;
            overflow-y: auto;
            padding: 2rem;
        }

        @media (max-width: 768px) {
            .app-content-area {
                padding: 1rem;
            }
        }

        .app-header {
            background: rgba(255,255,255,.6);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(30,41,59,.06);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
        }

        .mobile-menu-btn {
            display: none;
            background: transparent;
            border: 1px solid rgba(30,41,59,.12);
            padding: .5rem;
            border-radius: .5rem;
            cursor: pointer;
            color: var(--color-smoke);
        }

        @media (max-width: 768px) {
            .mobile-menu-btn { display: flex; align-items: center; justify-content: center; }
            .app-header { padding: .75rem 1rem; }
        }

        .app-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .app-content { padding: 1rem; }
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-subtitle {
            font-size: .875rem;
            color: rgba(30,41,59,.65);
        }

        /* Mobile overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.3);
            z-index: 99;
        }

        @media (max-width: 768px) {
            .sidebar-overlay.active { display: block; }
        }

        /* Utility for hiding sidebar on mobile */
        @media (max-width: 768px) {
            .app-sidebar { transform: translateX(-100%); }
            .app-sidebar.mobile-open { transform: translateX(0); }
        }
    </style>
</head>
<body class="bg-[var(--color-ivory)]">
    <div class="app-container">
        <!-- SIDEBAR -->
        <aside class="app-sidebar" id="appSidebar">
            <!-- Smart Toggle Button -->
            <button class="sidebar-smart-toggle" id="sidebarSmartToggle" aria-label="Toggle sidebar">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>

            <div class="sidebar-header">
                <a href="{{ route('home') }}" class="sidebar-brand">
                    <div class="w-8 h-8 rounded glass-card flex items-center justify-center shrink-0">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden>
                            <rect width="24" height="24" rx="5" fill="var(--color-terra)"/>
                            <path d="M7 13h10M7 9h10M7 17h6" stroke="var(--color-ivory)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span>Jackie</span>
                </a>
                <button class="sidebar-toggle-btn" id="sidebarCloseBtn" aria-label="Close sidebar">
                    ✕
                </button>
            </div>

            <nav class="sidebar-nav">
                @if(auth()->user()->isAdmin())
                    <!-- ADMIN NAVIGATION -->
                    <div class="nav-section">
                        <div class="nav-section-title">Dashboard</div>
                        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-title="Overview">
                            <span class="nav-icon">📊</span>
                            <span>Overview</span>
                        </a>
                    </div>

                    <div class="nav-section">
                        <div class="nav-section-title">Management</div>
                        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" data-title="Users">
                            <span class="nav-icon">👤</span>
                            <span>Users</span>
                        </a>
                        <a href="{{ route('admin.students.index') }}" class="nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}" data-title="Students">
                            <span class="nav-icon">👥</span>
                            <span>Students</span>
                        </a>
                        <a href="{{ route('admin.courses.index') }}" class="nav-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}" data-title="Courses">
                            <span class="nav-icon">📚</span>
                            <span>Courses</span>
                        </a>
                    </div>

                    <div class="nav-section">
                        <div class="nav-section-title">Business</div>
                        <a href="{{ route('admin.payments.index') }}" class="nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}" data-title="Payments">
                            <span class="nav-icon">💳</span>
                            <span>Payments</span>
                        </a>
                        <a href="{{ route('admin.subscriptions.index') }}" class="nav-item {{ request()->routeIs('admin.subscriptions.*') ? 'active' : '' }}" data-title="Subscriptions">
                            <span class="nav-icon">📦</span>
                            <span>Subscriptions</span>
                        </a>
                        <a href="{{ route('admin.subscription-plans.index') }}" class="nav-item {{ request()->routeIs('admin.subscription-plans.*') ? 'active' : '' }}" data-title="Plans">
                            <span class="nav-icon">📋</span>
                            <span>Plans</span>
                        </a>
                    </div>

                    <div class="nav-section">
                        <div class="nav-section-title">Features</div>
                        <a href="{{ route('admin.live-classes.index') }}" class="nav-item {{ request()->routeIs('admin.live-classes.*') ? 'active' : '' }}" data-title="Live Classes">
                            <span class="nav-icon">🎥</span>
                            <span>Live Classes</span>
                        </a>
                        <a href="{{ route('admin.quizzes.index') }}" class="nav-item {{ request()->routeIs('admin.quizzes.*') ? 'active' : '' }}" data-title="Quizzes">
                            <span class="nav-icon">✅</span>
                            <span>Quizzes</span>
                        </a>
                        <a href="{{ route('admin.certificates.index') }}" class="nav-item {{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}" data-title="Certificates">
                            <span class="nav-icon">🎓</span>
                            <span>Certificates</span>
                        </a>
                    </div>
                @else
                    <!-- STUDENT NAVIGATION -->
                    <div class="nav-section">
                        <div class="nav-section-title">Learning</div>
                        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-title="Dashboard">
                            <span class="nav-icon">🏠</span>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('student.courses') }}" class="nav-item {{ request()->routeIs('student.courses') ? 'active' : '' }}" data-title="My Courses">
                            <span class="nav-icon">📚</span>
                            <span>My Courses</span>
                        </a>
                        <a href="{{ route('student.catalog') }}" class="nav-item {{ request()->routeIs('student.catalog') ? 'active' : '' }}" data-title="Course Catalog">
                            <span class="nav-icon">🛒</span>
                            <span>Course Catalog</span>
                        </a>
                        <a href="{{ route('student.live-classes') }}" class="nav-item {{ request()->routeIs('student.live-classes') ? 'active' : '' }}" data-title="Live Classes">
                            <span class="nav-icon">🎥</span>
                            <span>Live Classes</span>
                            <span class="nav-badge">Today</span>
                        </a>
                        <a href="{{ route('student.tasks') }}" class="nav-item {{ request()->routeIs('student.tasks') ? 'active' : '' }}" data-title="My Tasks">
                            <span class="nav-icon">✅</span>
                            <span>My Tasks</span>
                            <span class="nav-badge">2</span>
                        </a>
                    </div>

                    <div class="nav-section">
                        <div class="nav-section-title">Progress</div>
                        <a href="{{ route('student.progress') }}" class="nav-item {{ request()->routeIs('student.progress') ? 'active' : '' }}" data-title="Progress">
                            <span class="nav-icon">📊</span>
                            <span>My Progress</span>
                        </a>
                        <a href="{{ route('student.certificates') }}" class="nav-item {{ request()->routeIs('student.certificates') ? 'active' : '' }}" data-title="Certificates">
                            <span class="nav-icon">🎓</span>
                            <span>My Certificates</span>
                        </a>
                    </div>

                    <div class="nav-section">
                        <div class="nav-section-title">Account</div>
                        <a href="{{ route('student.payments') }}" class="nav-item {{ request()->routeIs('student.payments') ? 'active' : '' }}" data-title="Payments">
                            <span class="nav-icon">💳</span>
                            <span>Payments</span>
                        </a>
                        <a href="{{ route('student.profile') }}" class="nav-item {{ request()->routeIs('student.profile') ? 'active' : '' }}" data-title="Profile">
                            <span class="nav-icon">👤</span>
                            <span>Profile</span>
                        </a>
                        <a href="{{ route('student.settings') }}" class="nav-item {{ request()->routeIs('student.settings') ? 'active' : '' }}" data-title="Settings">
                            <span class="nav-icon">⚙️</span>
                            <span>Settings</span>
                        </a>
                    </div>
                @endif
            </nav>

            <div class="sidebar-user" id="userMenuBtn">
                <div class="user-avatar">{{ auth()->user()->initials() }}</div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ auth()->user()->role->value }}</div>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="app-main">
            <!-- HEADER -->
            <header class="app-header">
                <div class="header-left">
                    <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Open menu">
                        ☰
                    </button>
                </div>

                <div class="flex items-center gap-4 ml-auto">
                    <button class="glass-outline px-3 py-2 rounded-md">
                        🔔
                    </button>
                    <div class="w-10 h-10 rounded-lg glass-card flex items-center justify-center cursor-pointer" id="headerUserBtn">
                        {{ auth()->user()->initials() }}
                    </div>
                </div>
            </header>

            <!-- CONTENT -->
            <div class="app-content-area">
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- SIDEBAR OVERLAY (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- USER DROPDOWN MENU (hidden by default) -->
    <div id="userMenu" style="display: none; position: fixed; top: 80px; right: 20px; background: white; border: 1px solid rgba(30,41,59,.12); border-radius: .75rem; padding: 0; min-width: 200px; box-shadow: 0 10px 30px rgba(30,41,59,.1); z-index: 200;">
        <a href="{{ route('profile.edit') }}" style="display: block; padding: .75rem 1rem; color: var(--color-smoke); text-decoration: none; font-size: .875rem; border-bottom: 1px solid rgba(30,41,59,.06);">⚙️ Settings</a>
        <form method="POST" action="{{ route('logout') }}" style="display: block;">
            @csrf
            <button type="submit" style="width: 100%; text-align: left; padding: .75rem 1rem; color: var(--color-smoke); border: none; background: transparent; cursor: pointer; font-size: .875rem;">🚪 Log out</button>
        </form>
    </div>

    <script>
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');
        const sidebarSmartToggle = document.getElementById('sidebarSmartToggle');
        const appSidebar = document.getElementById('appSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const userMenuBtn = document.getElementById('userMenuBtn');
        const headerUserBtn = document.getElementById('headerUserBtn');
        const userMenu = document.getElementById('userMenu');

        // Smart sidebar toggle (collapse/expand)
        sidebarSmartToggle?.addEventListener('click', () => {
            appSidebar.classList.toggle('collapsed');
            // Save preference to localStorage
            const isCollapsed = appSidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', isCollapsed ? 'true' : 'false');
        });

        // Restore sidebar state on load
        (function restoreSidebarState() {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed && window.innerWidth > 768) {
                appSidebar.classList.add('collapsed');
            }
        })();

        // Mobile menu toggle
        mobileMenuBtn?.addEventListener('click', () => {
            appSidebar.classList.toggle('mobile-open');
            sidebarOverlay.classList.toggle('active');
        });

        sidebarCloseBtn?.addEventListener('click', () => {
            appSidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.remove('active');
        });

        sidebarOverlay?.addEventListener('click', () => {
            appSidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.remove('active');
        });

        // User menu toggle
        userMenuBtn?.addEventListener('click', () => {
            userMenu.style.display = userMenu.style.display === 'none' ? 'block' : 'none';
        });

        headerUserBtn?.addEventListener('click', () => {
            userMenu.style.display = userMenu.style.display === 'none' ? 'block' : 'none';
        });

        // Close user menu when clicking elsewhere
        document.addEventListener('click', (e) => {
            if (!userMenuBtn?.contains(e.target) && !headerUserBtn?.contains(e.target) && !userMenu?.contains(e.target)) {
                userMenu.style.display = 'none';
            }
        });

        // Close sidebar on mobile after nav click
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', () => {
                appSidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
            });
        });

        // Close sidebar overlay on small screens when resizing
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                appSidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
            }
        });
    </script>

    @fluxScripts
</body>
</html>
