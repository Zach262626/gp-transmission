<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Experts in transmission repair and auto services in Campbellton. Call 506-790-7776 or submit a service request form.">
    <title>GP Transmission</title>
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph / social sharing --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="GP Transmission">
    <meta property="og:title" content="GP Transmission">
    <meta property="og:description" content="Experts in transmission repair and auto services in Campbellton. Call 506-790-7776 or submit a service request form.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('img/cards/og-share.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="644">
    <meta property="og:image:alt" content="GP Transmission & Auto Repair Inc., Campbellton NB">
    <meta name="twitter:card" content="summary_large_image">

    {{-- Fonts (loaded via <link> instead of a render-blocking @import in SCSS) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    @yield('header')
</head>

<body id="{{ $activePage }}">
    @include('layouts.navbars.nav_top', ['headerId' => $headerId ?? 'Header', 'type' => $type ?? 'main'])

    @yield('content')
    @include('layouts.footers.footer')

    {{-- Mobile-only tap-to-call button: keeps the primary conversion action one tap away. --}}
    <a href="tel:+15067907776" class="mobile-call-bar d-md-none" aria-label="Call GP Transmission at 506-790-7776">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
            class="bi bi-telephone-fill" viewBox="0 0 16 16" aria-hidden="true">
            <path fill-rule="evenodd"
                d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
        </svg>
    </a>

    @yield('js')
</body>

</html>