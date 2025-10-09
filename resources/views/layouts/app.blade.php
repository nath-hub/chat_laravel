{{-- resources/views/layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('app.css') }}">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        .app-container {
            display: flex;
            height: 100vh;
            position: relative;
        }

        /* S'assurer que le bouton reste au-dessus du menu mobile */
        .mobile-menu-btn {
            z-index: 1200;
        }

        /* S'assurer que le menu mobile reste visible au-dessus du contenu */
        .navigation-drawer {
            z-index: 1150;
        }


        /* Overlay pour mobile */
        .nav-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1050;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .nav-overlay.active {
            display: block;
            opacity: 1;
        }

        .navigation-drawer {
            width: 72px;
            background-color: var(--background-color);
            display: flex;
            flex-direction: column;
            height: 100%;
            transition: width 0.3s, transform 0.3s;
            overflow: hidden;
            z-index: 1060;
            position: relative;
        }

        .navigation-drawer.expanded {
            width: 300px;
        }

        /* Desktop: Menu visible, non déroulé par défaut */
        @media (min-width: 769px) {
            .navigation-drawer {
                width: 72px;
                position: relative;
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }

        /* Mobile: menu en position fixe, masqué par défaut */
        @media (max-width: 768px) {
            .navigation-drawer {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                transform: translateX(-100%);
                width: 72px;
            }

            .navigation-drawer.mobile-open {
                transform: translateX(0);
                width: 280px;
            }

            .main-content {
                width: 100%;
                margin-left: 0 !important;
            }

            /* Bouton hamburger pour mobile */
            .mobile-menu-btn {
                display: flex !important;
                position: fixed;
                top: 16px;
                left: 16px;
                z-index: 1100;
                background-color: var(--primary-color);
                color: white;
                border: none;
                border-radius: 50%;
                width: 48px;
                height: 48px;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
                transition: all 0.3s;
            }

            .mobile-menu-btn:hover {
                transform: scale(1.05);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            }
        }

        .mobile-menu-btn {
            display: none;
        }

        .main-content {
            flex: 1;
            overflow-y: auto;
            background-color: var(--background-color, #ffffff);
            height: 100vh;
        }

        /* Wrapper interne sans scroll */
        .drawer-inner {
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
        }

        .user-header {
            display: flex;
            align-items: center;
            padding: 16px 8px;
            gap: 12px;
            flex-shrink: 0;
            justify-content: center;
        }

        .navigation-drawer.expanded .user-header,
        .navigation-drawer.mobile-open .user-header {
            justify-content: flex-start;
            padding: 16px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            flex-shrink: 0;
            object-fit: cover;
            border: 2px solid rgba(0, 0, 0, 0.1);
        }

        .user-info {
            flex: 1;
            min-width: 0;
            display: none;

        }

        .navigation-drawer.expanded .user-info,
        .navigation-drawer.mobile-open .user-info {
            display: block;
        }

        .user-info .username {
            font-weight: 500;
            font-size: 18px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-info .email {
            font-size: 16px;
            opacity: 0.7;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .new-conversation-btn {
            margin: 8px;
            padding: 12px;
            border-radius: 10px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            cursor: pointer;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
            flex-shrink: 0;
            white-space: nowrap;
            width: 48px;
            height: 48px;
        }

        .navigation-drawer.expanded .new-conversation-btn,
        .navigation-drawer.mobile-open .new-conversation-btn {
            margin: 40px 40px 20px;
            width: auto;
            height: auto;
            padding: 12px 24px;
            justify-content: flex-start;
        }

        .new-conversation-btn span {
            display: none;
        }

        .navigation-drawer.expanded .new-conversation-btn span,
        .navigation-drawer.mobile-open .new-conversation-btn span {
            display: inline;
        }

        .divider {
            border-top: 1px solid rgba(0, 0, 0, 0.12);
            margin: 8px 0;
            flex-shrink: 0;
        }

        .chat-list {
            padding: 20px;
            overflow-y: auto;
            flex: 1;
            min-height: 0;
        }

        /* Masquer la scrollbar complètement */
        .chat-list::-webkit-scrollbar {
            width: 0;
            height: 0;
            display: none;
        }

        .chat-list {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .chat-list-title {
            font-size: 22px;
            text-align: center;
            margin-bottom: 20px;
            transition: font-size 0.2s;
        }

        .navigation-drawer:not(.expanded):not(.mobile-open) .chat-list-title {
            font-size: 0;
            margin-bottom: 0;
        }

        .chat-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            cursor: pointer;
            border-radius: 8px;
            margin-bottom: 4px;
            gap: 12px;
            text-decoration: none;
            color: inherit;
        }

        .navigation-drawer:not(.expanded):not(.mobile-open) .chat-item {
            padding: 12px;
            justify-content: center;
        }

        .chat-item:hover {
            background-color: var(--primary-over);
        }

        .chat-item.active {
            background-color: var(--primary-lighter);
        }

        .chat-item-title {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .navigation-drawer.expanded .chat-item-title,
        .navigation-drawer.mobile-open .chat-item-title {
            opacity: 1;
        }

        .spacer {
            flex: 1;
        }

        .footer-nav {
            padding: 8px;
            flex-shrink: 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            cursor: pointer;
            border-radius: 8px;
            margin-bottom: 4px;
            gap: 12px;
            text-decoration: none;
            color: inherit;
            font-size: 18px;
        }

        .navigation-drawer:not(.expanded):not(.mobile-open) .nav-item {
            padding: 12px;
            justify-content: center;
        }

        .nav-item:hover {
            background-color: rgba(0, 0, 0, 0.04);
        }

        .nav-item.active {
            background-color: rgba(25, 118, 210, 0.12);
            color: var(--primary-color);
        }

        .nav-item span {
            opacity: 0;
            transition: opacity 0.2s;
            white-space: nowrap;
        }

        .navigation-drawer.expanded .nav-item span,
        .navigation-drawer.mobile-open .nav-item span {
            opacity: 1;
        }

        .account-info {
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            flex-shrink: 0;
        }

        .navigation-drawer:not(.expanded):not(.mobile-open) .account-info {
            padding: 8px;
        }

        .account-type-wrapper {
            opacity: 0;
            transition: opacity 0.2s;
            max-height: 0;
            overflow: hidden;
        }

        .navigation-drawer.expanded .account-type-wrapper,
        .navigation-drawer.mobile-open .account-type-wrapper {
            opacity: 1;
            max-height: 100px;
        }

        .account-chip {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 16px;
            font-size: 12px;
            margin-top: 8px;
        }

        .account-chip.free {
            background-color: #ef5350;
            color: white;
        }

        .account-chip.premium {
            background-color: #4caf50;
            color: white;
        }

        .theme-toggle-btn {
            padding: 12px;
            border-radius: 8px;
            background-color: rgba(0, 0, 0, 0.04);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
        }

        .theme-toggle-btn span {
            opacity: 0;
            transition: opacity 0.2s;
            white-space: nowrap;
        }

        .navigation-drawer.expanded .theme-toggle-btn span,
        .navigation-drawer.mobile-open .theme-toggle-btn span {
            opacity: 1;
        }

        .toggle-rail-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            flex-shrink: 0;
            transition: opacity 0.2s;
            display: none;
        }

        .navigation-drawer.expanded .toggle-rail-btn,
        .navigation-drawer.mobile-open .toggle-rail-btn {
            display: block;
        }

        /* Desktop: afficher le toggle uniquement sur PC */
        @media (min-width: 769px) {
            .toggle-rail-btn {
                display: block !important;
            }
        }

        @media (max-width: 768px) {
            .toggle-rail-btn {
                display: none !important;
            }
        }

        /* Ajustement pour le contenu principal sur desktop */
        @media (min-width: 769px) {
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body data-theme="{{ $user->theme ?? 'light' }}">

    <!-- Bouton hamburger mobile -->
    <button class="mobile-menu-btn" id="mobileMenuBtn" onclick="toggleMobileMenu()">
        <i class="mdi mdi-menu"></i>
    </button>

    <!-- Overlay pour fermer le menu sur mobile -->
    <div class="nav-overlay" id="navOverlay" onclick="closeMobileMenu()"></div>

    <div class="app-container">

        <aside class="navigation-drawer" id="navigationDrawer">
            <div class="drawer-inner">
                <!-- Header section -->
                <div class="user-header">
                    <img src="{{ $user->avatar ?? 'https://www.gravatar.com/avatar/?d=mp&s=200' }}" alt="Avatar"
                        class="user-avatar">
                    <div class="user-info">
                        <div class="username">{{ $user->username ?? 'Invité' }}</div>
                        <div class="email">{{ $user->email ?? '' }}</div>
                    </div>
                    <button class="toggle-rail-btn" onclick="toggleRail()" title="Dérouler le menu">
                        <i class="mdi mdi-chevron-right" id="railIcon" style="font-size: 24px;"></i>
                    </button>
                </div>

                <button class="new-conversation-btn" onclick="handleNewConversation()">
                    <i class="mdi mdi-square-edit-outline"></i>
                    <span>Nouvelle conversation</span>
                </button>

                <div class="divider"></div>

                <div class="chat-list">
                    <div class="chat-list-title">Chats</div>

                    @forelse($conversations as $conversation)
                        <a href="{{ route('chat.show', $conversation->id) }}"
                            class="chat-item {{ $activeConversationId == $conversation->id ? 'active' : '' }}"
                            onclick="handleChatClick(event)">
                            <i class="mdi mdi-message-text-outline"></i>
                            <span class="chat-item-title">{{ $conversation->title }}</span>
                        </a>

                    @empty
                        <div class="chat-item" style="pointer-events: none;">
                            <i class="mdi mdi-message-off-outline" style="opacity: 0.6;"></i>
                            <span class="chat-item-title" style="opacity: 0.6;">Aucune conversation</span>
                        </div>
                    @endforelse
                </div>

                <!-- Spacer -->
                <div class="spacer"></div>

                <!-- Footer nav links -->
                <nav class="footer-nav">
                    <a href="{{ route('home') }}"
                        class="nav-item {{ Route::currentRouteName() == 'home' ? 'active' : '' }}"
                        onclick="handleNavClick(event)">
                        <i class="mdi mdi-home-city"></i>
                        <span>Home</span>
                    </a>
                    <a href="{{ route('abonnement') }}"
                        class="nav-item {{ Route::currentRouteName() == 'abonnement' ? 'active' : '' }}"
                        onclick="handleNavClick(event)">
                        <i class="mdi mdi-seal"></i>
                        <span>S'abonner</span>
                    </a>
                    <a href="{{ route('profil') }}"
                        class="nav-item {{ Route::currentRouteName() == 'profil' ? 'active' : '' }}"
                        onclick="handleNavClick(event)">
                        <i class="mdi mdi-account-star"></i>
                        <span>Profil</span>
                    </a>
                </nav>

                <!-- Theme toggle at the very bottom -->
                <div class="account-info">
                    <div class="account-type-wrapper">
                        <label style="font-size: 14px;">Type de compte</label>
                        <span
                            class="account-chip {{ ($user->type_abonnement ?? 'free') === 'free' ? 'free' : 'premium' }}">
                            {{ ucfirst($user->type_abonnement ?? 'free') }}
                        </span>
                    </div>

                    <form action="{{ route('theme.toggle') }}" method="POST" id="themeForm">
                        @csrf
                        <button type="submit" class="theme-toggle-btn">
                            @php
                                $theme = optional($user)->theme ?? 'light';
                            @endphp

                            <i
                                class="mdi {{ $theme === 'dark' ? 'mdi-white-balance-sunny' : 'mdi-moon-waning-crescent' }}"></i>
                            <span>{{ $theme === 'dark' ? 'Mode clair' : 'Mode sombre' }}</span>

                        </button>
                    </form>
                </div>
            </div>
        </aside>


        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <script>
        const isMobile = () => window.innerWidth <= 768;

        // Toggle rail sur desktop
        function toggleRail() {
            if (!isMobile()) {
                const drawer = document.getElementById('navigationDrawer');
                const icon = document.getElementById('railIcon');
                drawer.classList.toggle('expanded');

                if (drawer.classList.contains('expanded')) {
                    icon.className = 'mdi mdi-chevron-left';
                } else {
                    icon.className = 'mdi mdi-chevron-right';
                }
            }
        }

        // Toggle menu sur mobile
        function toggleMobileMenu() {
            const drawer = document.getElementById('navigationDrawer');
            const overlay = document.getElementById('navOverlay');
            const menuIcon = document.getElementById('menuIcon'); // ton icône de menu mobile

            drawer.classList.toggle('mobile-open');
            overlay.classList.toggle('active');

            // cacher ou afficher l'icône du menu sur mobile
            if (drawer.classList.contains('mobile-open')) {
                menuIcon.style.display = 'none';
            } else {
                menuIcon.style.display = 'block';
            }
        }

        // Fermer le menu mobile
        function closeMobileMenu() {
            if (isMobile()) {
                const drawer = document.getElementById('navigationDrawer');
                const overlay = document.getElementById('navOverlay');
                const menuIcon = document.getElementById('menuIcon');

                drawer.classList.remove('mobile-open');
                overlay.classList.remove('active');
                menuIcon.style.display = 'block'; // réafficher l'icône quand on ferme
            }
        }

        // Gérer le clic sur nouvelle conversation
        function handleNewConversation() {
            closeMobileMenu();
            window.location.href = '{{ route('home') }}';
        }

        // Gérer le clic sur un item de chat
        function handleChatClick(event) {
            closeMobileMenu();
        }

        // Gérer le clic sur un item de navigation
        function handleNavClick(event) {
            closeMobileMenu();
        }

        // Theme toggle avec AJAX
        document.getElementById('themeForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

            // Récupère l'élément <html> ou <body>
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);


            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        // Gérer le redimensionnement de la fenêtre
        window.addEventListener('resize', function() {
            const drawer = document.getElementById('navigationDrawer');
            const overlay = document.getElementById('navOverlay');
            const menuIcon = document.getElementById('menuIcon');

            if (!isMobile()) {
                drawer.classList.add('expanded'); // ouvert par défaut sur PC
                drawer.classList.remove('mobile-open');
                overlay.classList.remove('active');
                if (menuIcon) menuIcon.style.display = 'none'; // pas besoin d’icône sur desktop
            } else {
                drawer.classList.remove('expanded');
                drawer.classList.remove('mobile-open');
                overlay.classList.remove('active');
                if (menuIcon) menuIcon.style.display = 'block'; // réaffiche sur mobile
            }
        });

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            const drawer = document.getElementById('navigationDrawer');
            const icon = document.getElementById('railIcon');
            const menuIcon = document.getElementById('menuIcon');

            if (!isMobile()) {
                drawer.classList.add('expanded'); // ouvert par défaut sur PC
                if (icon) icon.className = 'mdi mdi-chevron-left';
                if (menuIcon) menuIcon.style.display = 'none';
            } else {
                drawer.classList.remove('expanded');
                if (menuIcon) menuIcon.style.display = 'block';
            }
        });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
