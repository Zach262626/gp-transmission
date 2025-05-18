<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <style>
        html {
            visibility: hidden;
            background: #000c21;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Owl Carousel Styles --}}
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">


    <link rel="shortcut icon" href="./favicon.ico">
    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <title>GP Transmission</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    <!-- Loader CSS only uses dark background -->
    @yield('header')
</head>
<body id="{{ $activePage }}">
    @include('layouts.navbars.nav_top', ['headerId' => $headerId ?? 'Header', 'type' => $type ?? 'main'])

    @yield('content')
    @include('layouts.footers.footer')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous">
        </script>
    @yield('js')
    {{-- owl carousel --}}
    <script type="module" src="js/owl.carousel.min.js"></script>
    <script>
        window.addEventListener('load', () => {
            document.documentElement.style.visibility = 'visible';
            document.documentElement.style.background = 'none';
            document.getElementById('Loader').style.display = 'none';
        });
    </script>
    <script type="module">
        jQuery(window).on("load", function () {
            $('#Loader').hide();
        });
    </script>
</body>

</html>