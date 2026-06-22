@extends('layouts.app', ['activePage' => 'AboutPage', 'type' => 'main'])

@section('title', 'About GP Transmission | Auto Shop in Campbellton, NB')
@section('meta_description', 'GP Transmission & Auto Repair Inc. is a locally owned full-service auto shop in Campbellton, NB, specializing in transmission repair. Call 506-790-7776.')

@section('content')
    <div class="container my-5 text-light">
        <h1 class="mb-4">About GP Transmission</h1>

        <div class="row g-4">
            <div class="col-lg-7">
                {{-- TODO (owner): personalize this story — years in business, the owner's
                     background, and your team. A real photo of the shop/team belongs here
                     (run it through the WebP image pipeline). Authentic copy builds trust. --}}
                <p class="lead">
                    GP Transmission &amp; Auto Repair Inc. is a locally owned, full-service auto shop in
                    Campbellton, New Brunswick. Transmission repair is our specialty, and we also handle
                    everything from brakes and tires to MVI inspections and oil changes.
                </p>
                <p>
                    We're proud to serve drivers across Campbellton and the Restigouche region with honest
                    diagnostics and quality workmanship. When something's wrong with your vehicle, we'll
                    explain what we find in plain language before any work begins.
                </p>

                {{-- TODO (owner): if you offer a workmanship/parts warranty, state the exact
                     terms here (e.g. "12-month / 20,000 km warranty on transmission rebuilds").
                     This is the single biggest trust signal for transmission work. --}}
                <h2 class="h4 mt-4">Our Commitment</h2>
                <p>
                    Quality work, fair pricing, and clear communication on every job.
                </p>

                <div class="mt-4">
                    <a href="{{ route('contact') }}" class="btn btn-light btn-lg fw-bold">Request Service</a>
                    <a href="tel:+15067907776" class="btn btn-outline-light btn-lg ms-2">Call 506-790-7776</a>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="reach-us shadow-lg border border-light border-1 container h-100 p-3 text-light">
                    <h2 class="h4">Visit Us</h2>
                    <ul class="list-unstyled">
                        <li>GP Transmission &amp; Auto Repair Inc.</li>
                        <li>47 Rue Vanier</li>
                        <li>Campbellton, NB</li>
                        <li>E3N 1T8</li>
                    </ul>
                    <p class="mb-1">Phone: <a href="tel:+15067907776" class="reach-us-link">506-790-7776</a></p>
                    <h2 class="h5 mt-3">Hours</h2>
                    <ul class="list-unstyled mb-0">
                        <li>Mon&ndash;Thu: 7:00&ndash;17:00</li>
                        <li>Fri: 7:00&ndash;12:00</li>
                        <li>Sat&ndash;Sun: Closed</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
