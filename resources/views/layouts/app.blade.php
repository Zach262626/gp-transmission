<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    {{-- Owl Carousel Styles --}}
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    {{-- Jquery --}}
    <script
			  src="https://code.jquery.com/jquery-3.7.1.js"
			  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
			  crossorigin="anonymous"></script>
    @yield('header')
    <title>GP Transmission</title>
    <style>
        div#Loader {
            z-index: 9999999;
            position:fixed;
            width: 100%;
            height: 100%;
            background: white;
            top: 0;
            left:0;
        }
    </style>
</head>

<body id="{{ $activePage }}">
    <div class="h-100 w-100 bg-dark position-fixed" id="Loader">
        <div class="spinner-border position-fixed end-50 bottom-50" style="width: 4rem; height: 4rem; color:white;"
            role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    @yield('content')
    <script
			  src="https://code.jquery.com/jquery-3.7.1.min.js"
			  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
			  crossorigin="anonymous">
    </script>
    @yield('js')
    {{-- owl carousel --}}
    <script type="module" src="js/owl.carousel.min.js"></script>
    <script type="module">
        jQuery(window).on("load", function () {
            $('#Loader').hide();
        });
    </script>
</body>

</html>
