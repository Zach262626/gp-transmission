@extends('layouts.app', ['activePage' => 'ServicesPage', 'type' => 'main'])

@section('title', 'Auto & Transmission Services in Campbellton, NB | GP Transmission')
@section('meta_description', 'Transmission repair and rebuilds, brakes, tires, oil changes, MVI inspections, tune-ups and more in Campbellton, NB. Call 506-790-7776.')

@section('header')
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "Do I need an appointment for service?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "An appointment helps us serve you faster. Submit a service request online or call 506-790-7776 to book a time."
          }
        },
        {
          "@type": "Question",
          "name": "Do you perform Motor Vehicle Inspections (MVI)?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes. We perform New Brunswick Motor Vehicle Inspections along with general auto repair and maintenance."
          }
        },
        {
          "@type": "Question",
          "name": "What areas do you serve?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "We serve Campbellton and the surrounding Restigouche region from our shop at 47 Rue Vanier, Campbellton, NB."
          }
        }
      ]
    }
    </script>
@endsection

@section('content')
    <div class="container my-5 text-light">
        <h1 class="mb-4">Our Services in Campbellton, NB</h1>
        <p class="lead">
            A full-service auto shop specializing in transmission repair, serving Campbellton and the
            Restigouche region.<span class="d-none d-md-inline"> From a slipping transmission to a routine
                oil change, our team keeps your vehicle on the road.</span>
        </p>

        <div class="row g-4 mt-2">
            <div class="col-md-6">
                <h2 class="h4">Transmission Repair &amp; Rebuilds</h2>
                <p>Diagnostics, repairs and full rebuilds for automatic and manual transmissions —
                    our core specialty.</p>
            </div>
            <div class="col-md-6">
                <h2 class="h4">Motor Vehicle Inspection (MVI)</h2>
                <p>Official New Brunswick safety inspections so your vehicle stays road-legal.</p>
            </div>
            <div class="col-md-6">
                <h2 class="h4">Brakes</h2>
                <p>Brake inspection, pad and rotor replacement, and full brake service.</p>
            </div>
            <div class="col-md-6">
                <h2 class="h4">Tires</h2>
                <p>Mounting, balancing, rotation and seasonal tire changeovers.</p>
            </div>
            <div class="col-md-6">
                <h2 class="h4">Oil Changes &amp; Tune-Ups</h2>
                <p>Routine maintenance to keep your engine running smoothly and reliably.</p>
            </div>
            <div class="col-md-6">
                <h2 class="h4">Suspension, A/C, Batteries &amp; More</h2>
                <p>General auto repair including suspension work, air conditioning and battery replacement.</p>
            </div>
        </div>

        <div class="mt-5">
            <a href="{{ route('contact') }}" class="btn btn-light btn-lg fw-bold">Request Service</a>
            <a href="tel:+15067907776" class="btn btn-outline-light btn-lg ms-2">Call 506-790-7776</a>
        </div>
    </div>
@endsection
