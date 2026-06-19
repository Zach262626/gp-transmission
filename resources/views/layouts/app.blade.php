<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Experts in transmission repair and auto services in Campbellton. Call 506-790-7776 or submit a service request form.">

    <link rel="shortcut icon" href="./favicon.ico">
    {{-- jQuery: single synchronous copy. The /testing page's classic inline scripts and select2 need it before parse, so do NOT add defer. --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>GP Transmission</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    @yield('header')
</head>

<body id="{{ $activePage }}">
    @include('layouts.navbars.nav_top', ['headerId' => $headerId ?? 'Header', 'type' => $type ?? 'main'])

    @yield('content')
    @include('layouts.footers.footer')
    @yield('js')
</body>

</html>