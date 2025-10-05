{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">


    <!-- ✅ Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optionnel : icônes Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .app-container {
            display: flex;
            height: 100vh;
        }

        .navigation-drawer {
            width: 300px;
            background-color: var(--surface-color, #f5f5f5);
            display: flex;
            flex-direction: column;
            height: 100%;
            transition: width 0.3s;
        }

        .navigation-drawer.rail {
            width: 72px;
        }

        .main-content {
            flex: 1;
            overflow-y: auto;
            background-color: var(--background-color, #ffffff);
        }

        .user-header {
            display: flex;
            align-items: center;
            padding: 16px;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .rail .user-avatar {
            width: 32px;
            height: 32px;
        }

        .user-info {
            flex: 1;
        }

        .rail .user-info {
            display: none;
        }

        .new-conversation-btn {
            margin: 40px 40px 20px;
            padding: 12px 24px;
            border-radius: 10px;
            background-color: var(--primary-color, #1976d2);
            color: white;
            border: none;
            cursor: pointer;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.2s;
        }

        .rail .new-conversation-btn {
            margin: 8px 4px;
            width: 45px;
            height: 45px;
            padding: 0;
            justify-content: center;
        }

        .rail .new-conversation-btn span {
            display: none;
        }

        .divider {
            border-top: 1px solid rgba(0, 0, 0, 0.12);
            margin: 8px 0;
        }

        .chat-list {
            padding: 20px;
        }

        .chat-list-title {
            font-size: 22px;
            text-align: center;
            margin-bottom: 20px;
        }

        .chat-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            cursor: pointer;
            border-radius: 8px;
            margin-bottom: 4px;
            gap: 12px;
        }

        .chat-item:hover {
            background-color: rgba(0, 0, 0, 0.04);
        }

        .chat-item.active {
            background-color: rgba(25, 118, 210, 0.12);
        }

        .chat-item-title {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        .spacer {
            flex: 1;
        }

        .footer-nav {
            padding: 8px;
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

        .nav-item:hover {
            background-color: rgba(0, 0, 0, 0.04);
        }

        .nav-item.active {
            background-color: rgba(25, 118, 210, 0.12);
            color: var(--primary-color, #1976d2);
        }

        .rail .nav-item span {
            display: none;
        }

        .account-info {
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
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

        .rail .theme-toggle-btn span {
            display: none;
        }

        .toggle-rail-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
        }
    </style>
</head>

<body>
    <div class="app-container">
        @unless (in_array(Route::currentRouteName(), ['landing', 'verify', 'login']))
            <aside class="navigation-drawer" id="navigationDrawer">
                <div style="display: flex; flex-direction: column; height: 100%;">
                    <!-- Header section -->
                    <div class="user-header">
                        <img src="{{ $user->avatar ?? 'https://www.gravatar.com/avatar/?d=mp&s=200' }}" alt="Avatar"
                            class="user-avatar">
                        <div class="user-info">
                            <div style="font-weight: 500;">{{ $user->username ?? 'Invité' }}</div>
                            <div style="font-size: 12px; opacity: 0.7;">{{ $user->email ?? '' }}</div>
                        </div>
                        <button class="toggle-rail-btn" onclick="toggleRail()">
                            <i class="mdi mdi-chevron-left" id="railIcon"></i>
                        </button>
                    </div>

                    <button class="new-conversation-btn" onclick="window.location.href='{{ route('home') }}'">
                        <i class="mdi mdi-square-edit-outline"></i>
                        <span>Nouvelle conversation</span>
                    </button>

                    <div class="divider"></div>

                    <div class="chat-list">
                        <div class="chat-list-title">Chats</div>

                        @forelse($conversations as $conversation)
                            <a href="{{ route('chat.show', $conversation->id) }}"
                                class="chat-item {{ $activeConversationId == $conversation->id ? 'active' : '' }}">
                                <i class="mdi mdi-message-text-outline"></i>
                                <span class="chat-item-title">{{ $conversation->title }}</span>
                            </a>
                        @empty
                            <p>Aucune conversation trouvée.</p>
                        @endforelse




                    </div>

                    <!-- Spacer -->
                    <div class="spacer"></div>

                    <!-- Footer nav links -->
                    <nav class="footer-nav">
                        <a href="{{ route('home') }}"
                            class="nav-item {{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
                            <i class="mdi mdi-home-city"></i>
                            <span>Home</span>
                        </a>
                        <a href="{{ route('abonnement') }}"
                            class="nav-item {{ Route::currentRouteName() == 'abonnement' ? 'active' : '' }}">
                            <i class="mdi mdi-seal"></i>
                            <span>S'abonner</span>
                        </a>
                        <a href="{{ route('profil') }}"
                            class="nav-item {{ Route::currentRouteName() == 'profil' ? 'active' : '' }}">
                            <i class="mdi mdi-account-star"></i>
                            <span>Profil</span>
                        </a>

                    </nav>

                    <!-- Theme toggle at the very bottom -->
                    <div class="account-info">
                        <div>
                            <label style="font-size: 14px;">Type de compte</label>

                            <span class="account-chip {{ $user->type_abonnement == 'free' ? 'free' : 'premium' }}">
                                {{ $user->type_abonnement }}
                            </span>


                        </div>

                        <form action="{{ route('theme.toggle') }}" method="POST" id="themeForm">
                            @csrf

                            <button type="submit" class="theme-toggle-btn">
                                <i
                                    class="mdi {{ $user->theme === 'dark' ? 'mdi-white-balance-sunny' : 'mdi-moon-waning-crescent' }}"></i>
                                <span>{{ $user->theme === 'dark' ? 'Mode clair' : 'Mode sombre' }}</span>

                        </form>
                    </div>
                </div>
            </aside>
        @endunless

        <main class="main-content">
            @yield('content')
        </main>

    </div>

    <script>
        function toggleRail() {
            const drawer = document.getElementById('navigationDrawer');
            const icon = document.getElementById('railIcon');
            drawer.classList.toggle('rail');

            if (drawer.classList.contains('rail')) {
                icon.className = 'mdi mdi-chevron-right';
            } else {
                icon.className = 'mdi mdi-chevron-left';
            }
        }

        // Theme toggle with AJAX
        document.getElementById('themeForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

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
    </script>
</body>

<!-- Bootstrap JS Bundle (avec Popper) -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
