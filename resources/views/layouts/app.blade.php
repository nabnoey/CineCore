<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CineCore</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>
<body style="background-color: #121212;">
    <div id="app" class="text-black">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md shadow-sm border-bottom {{ Route::is('admin.movies.edit') ? 'navbar-light bg-light' : 'navbar-dark bg-black border-secondary' }}">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    CineCore
                </a>

                <!-- Mobile Toggle Button -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar Links -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto"></ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('admin.movies.edit') ? 'text-dark' : 'text-white' }}" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('admin.movies.edit') ? 'text-dark' : 'text-white' }}" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center {{ Route::is('admin.movies.edit') ? 'text-dark' : 'text-white' }}" href="#" role="button"
                                   data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @if(Auth::user()->profile_image)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-circle me-2" viewBox="0 0 16 16">
                                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                        </svg>
                                    @endif
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        โปรไฟล์
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Ensure Navbar Dropdown works even if Vite-compiled JS isn't loaded
        (function () {
            function initDropdowns() {
                if (window.bootstrap && window.bootstrap.Dropdown) {
                    document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function (el) {
                        try { new window.bootstrap.Dropdown(el); } catch (e) {}
                    });
                }
            }

            function initManualDropdown() {
                // Minimal manual toggle if Bootstrap is unavailable
                var trigger = document.getElementById('navbarDropdown');
                if (!trigger || trigger.getAttribute('data-manual-dropdown') === 'true') return;
                trigger.setAttribute('data-manual-dropdown', 'true');
                var parent = trigger.closest('.dropdown');
                if (!parent) return;
                var menu = parent.querySelector('.dropdown-menu');
                if (!menu) return;

                function closeAll(e) {
                    if (!parent.contains(e.target)) {
                        menu.classList.remove('show');
                        trigger.setAttribute('aria-expanded', 'false');
                    }
                }

                trigger.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var willShow = !menu.classList.contains('show');
                    menu.classList.toggle('show', willShow);
                    trigger.setAttribute('aria-expanded', willShow ? 'true' : 'false');
                });

                document.addEventListener('click', closeAll);
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') closeAll({ target: document.body });
                });
            }

            if (typeof window.bootstrap === 'undefined') {
                var s = document.createElement('script');
                s.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js';
                s.crossOrigin = 'anonymous';
                s.onload = initDropdowns;
                document.head.appendChild(s);
                // Also bind manual fallback in case CDN blocked
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initManualDropdown);
                } else {
                    initManualDropdown();
                }
            } else {
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initDropdowns);
                } else {
                    initDropdowns();
                }
            }
        })();
    </script>
</body>
</html>

