<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title></title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    {{-- Owl Carousel Styles --}}
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    {{-- Jquery Slim version for owl carousel to work --}}
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    @yield('header')
</head>

<body id="{{ $activePage }}">
    <div class="h-100 w-100 bg-dark position-fixed" style="z-index: 2000" id="Loader">
        <div class="spinner-border position-fixed end-50 bottom-50" style="width: 4rem; height: 4rem; color:white;"
            role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    @yield('content')
    @yield('js')
    {{-- owl carousel --}}
    <script type="module" src="js/owl.carousel.min.js"></script>
    <script type="module">
        $(window).on('load', function() {
            $('#Loader').hide();
        })
    </script>
</body>

</html>
