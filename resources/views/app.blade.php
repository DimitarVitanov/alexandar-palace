<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @inertiaHead

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('assets/paradise/img/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('assets/paradise/img/apple-touch-icon-57x57-precomposed.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/paradise/img/apple-touch-icon-72x72-precomposed.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/paradise/img/apple-touch-icon-114x114-precomposed.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/paradise/img/apple-touch-icon-144x144-precomposed.png') }}">

    @vite(['resources/js/app.js'])

    <link href="{{ asset('assets/paradise/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/paradise/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/paradise/css/vendors.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/paradise/css/custom.css') }}" rel="stylesheet">
</head>
<body class="@yield('body_class', '')">
    <div id="preloader">
        <div data-loader="circle-side"></div>
    </div>

    @inertia

    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
        </svg>
    </div>

    <script>
        (function () {
            function hidePreloader() {
                var preloader = document.getElementById('preloader');
                if (preloader) {
                    preloader.classList.add('loaded');
                }
                var loader = document.querySelector('[data-loader="circle-side"]');
                if (loader) {
                    loader.style.opacity = '0';
                    loader.style.transition = 'opacity 0.2s ease';
                }
                var hero = document.querySelector('.animate_hero');
                if (hero) {
                    hero.classList.add('is-transitioned');
                }
            }
            if (document.readyState === 'complete') {
                hidePreloader();
            } else {
                window.addEventListener('load', hidePreloader);
                setTimeout(hidePreloader, 800);
            }
        })();
    </script>
    <script src="{{ asset('assets/paradise/js/common_scripts.js') }}" defer></script>
</body>
</html>
