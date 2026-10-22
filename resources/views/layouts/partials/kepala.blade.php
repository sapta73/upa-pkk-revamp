    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('judul', 'UPA PKK UBB')</title>
    <meta name="description" content="UPA PKK UBB">
    <link rel="icon" href="{{ asset('img/logo upa pkk.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        #scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #eab308, #f59e0b);
            transform-origin: left center;
            transform: scaleX(0);
            z-index: 9999;
            will-change: transform;
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
            [data-reveal], [data-stagger] > * {
                opacity: 1 !important;
                transform: none !important;
            }
        }
    </style>
    @livewireStyles
    @stack('styles')
