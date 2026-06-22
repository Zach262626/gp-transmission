@extends('layouts.app', ['activePage' => 'MainPage', 'type' => 'main']) {{-- **IMPORTANT TO ADD activePage for styling** --}}

@section('title', 'Transmission Repair & Auto Service in Campbellton, NB | GP Transmission')
@section('meta_description', 'GP Transmission is Campbellton\'s trusted shop for transmission repair, MVI inspections, brakes, tires, oil changes and tune-ups. Call 506-790-7776 or request service online.')

@section('header')
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "AutoRepair",
      "name": "GP Transmission & Auto Repair Inc.",
      "image": "{{ asset('img/cards/gptransmission.png') }}",
      "@id": "{{ url('/') }}#business",
      "url": "{{ url('/') }}",
      "telephone": "+1-506-790-7776",
      "priceRange": "$$",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "47 Rue Vanier",
        "addressLocality": "Campbellton",
        "addressRegion": "NB",
        "postalCode": "E3N 1T8",
        "addressCountry": "CA"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 48.003833,
        "longitude": -66.654083
      },
      "areaServed": ["Campbellton", "Atholville", "Tide Head", "Restigouche"],
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday"],
          "opens": "07:00",
          "closes": "17:00"
        },
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": "Friday",
          "opens": "07:00",
          "closes": "12:00"
        }
      ],
      "sameAs": [
        "https://www.facebook.com/SgAutoTransmission"
      ]
    }
    </script>
@endsection

@section('content')
    <div id="Header">
        <img class="header_bg" src="./img/cards/gptransmission.png" alt="" fetchpriority="high">
        <div class="container">
            <div class="section_content row">
                <div class="col-12">
                    <h1 class="header_content-description">Transmission Repair &amp; Auto Service in Campbellton, NB</h1>
                </div>
            </div>
            {{-- ADD APPOINTMENT --}}
            <div class="section_content row mt-5">
                <div class="col-12">
                    <form action="{{ route('contact') }}" method="get">
                        <button type="submit" class="btn shadow-lg h-100 fs-2 rounded appointment-button">
                            <strong>Request Service</strong>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="Main">
        <div class="container mt-4">
            <div class="row align-items-center">
                <div class="col-md-5 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-1">
                        <h2 class="main-item-header fs-1" style="z-index:11; position: relative;">TIRES</h2>
                        <div class="main-item-description"><img class="header_bg" src="./img/cards/tire.png" alt="" loading="lazy" decoding="async">
                        </div>
                    </div>
                </div>
                <div class="col-md-7 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-2">
                        <h2 class="main-item-header">TRANSMISSIONS</h2>
                        <div class="main-item-description"><img class="header_bg" src="./img/cards/car.png" alt="" loading="lazy" decoding="async">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-4 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-3">
                        <h2 class="main-item-header">MOTOR VEHICLE INSPECTION</h2>
                        <div class="main-item-description"><img class="header_bg" src="./img/cards/key.png" alt="" loading="lazy" decoding="async">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-4">
                        <h2 class="main-item-header">OIL
                            CHANGES</h2>
                        <div class="main-item-description"><img class="header_bg" src="./img/cards/oil.png" alt="" loading="lazy" decoding="async">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-5">
                        <h2 class="main-item-header">BRAKES</h2>
                        <div class="main-item-description"><img class="header_bg" src="./img/cards/pedals.png"
                                alt="" loading="lazy" decoding="async"></div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center mb-5">
                <div class="col-md-7 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-6">
                        <h2 class="main-item-header">TUNE
                            UPS</h2>
                        <div class="main-item-description"><img class="header_bg" src="./img/cards/car2.png" alt="" loading="lazy" decoding="async">
                        </div>
                    </div>
                </div>
                <div class="col-md-5 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-7">
                        <h2 class="main-item-header">+ SUSPENSION</h2>
                        <h2 class="main-item-header">+ AIR CONDITIONER</h2>
                        <h2 class="main-item-header">+ BATTERIES</h2>
                        <h2 class="main-item-header">+ MORE</h2>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- Why choose us — trust signals. NOTE for owner: if you offer a workmanship/parts
         warranty, add it here (e.g. "12-month / 20,000 km warranty") — it is the single
         biggest objection-remover for transmission work. --}}
    <div id="WhyUs" class="py-5">
        <div class="container">
            <h2 class="text-light text-center mb-4">Why Choose GP Transmission</h2>
            <div class="row g-3">
                <div class="col-md-3 col-6">
                    <div class="why-card h-100 text-center p-3">
                        <strong>Transmission Specialists</strong>
                        <p class="mb-0 d-none d-md-block">Rebuilds, repairs and diagnostics are our core trade.</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="why-card h-100 text-center p-3">
                        <strong>Full-Service Shop</strong>
                        <p class="mb-0 d-none d-md-block">Brakes, tires, oil, MVI inspections, tune-ups and more.</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="why-card h-100 text-center p-3">
                        <strong>Honest Diagnostics</strong>
                        <p class="mb-0 d-none d-md-block">Clear explanations before any work begins.</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="why-card h-100 text-center p-3">
                        <strong>Local to Campbellton</strong>
                        <p class="mb-0 d-none d-md-block">Serving Campbellton &amp; the Restigouche region.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Real social proof: link out to the live Google Business Profile instead of
         shipping a fabricated testimonial. Replace with cached, server-side Google
         reviews once a Places API key is available. --}}
    <div id="Reviews" class="py-5">
        <div class="container text-center">
            <h2 class="text-light mb-3">What Our Customers Say</h2>
            <p class="text-light mb-4 d-none d-md-block">
                Read verified reviews from real customers on our Google Business Profile.
            </p>
            <a href="https://g.co/kgs/itpTF2k" target="_blank" rel="noopener"
                class="btn btn-light btn-lg">Read our Google reviews</a>
        </div>
    </div>
    <div id="Contact">
        <div class="container my-5">
            <div class="row align-items-center">
                <div class="col-md-12 contact-item-md contact-map">
                    {{-- Map facade: defers loading the heavy Google Maps payload until the
                         visitor asks for it (click), keeping initial page load fast. --}}
                    <div class="h-100 map-facade"
                        data-map-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2669.5111874695913!2d-66.65408332358444!3d48.003833071229046!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4c982123f39f9b47%3A0x24d7005ac2504c44!2sGP%20Transmission%20%26%20Auto%20repair%20Inc.!5e0!3m2!1sen!2sca!4v1723596212599!5m2!1sen!2sca">
                        <button type="button" class="btn btn-light map-facade-btn w-100 h-100">
                            <strong>📍 View map — GP Transmission, 47 Rue Vanier, Campbellton</strong>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-md-6 contact-item-md">
                    <div class="reach-us shadow-lg border border-black border-1 container h-100">
                        <div class="fs-2">
                            <strong>HOW TO REACH US</strong>
                        </div>
                        <div>Phone: <a href="tel:+15067907776" class="reach-us-link">506-790-7776</a></div>
                        {{-- TODO (owner): replace the personal Hotmail with a branded address
                             (e.g. info@yourdomain.ca) once that mailbox exists. --}}
                        <div class="border-middle pb-2">e-mail:
                            <a href="mailto:sebgallant@hotmail.com" class="reach-us-link">sebgallant@hotmail.com</a>
                        </div>
                        <div class="fs-2">
                            <strong>Location</strong>
                        </div>
                        <ul class="list-unstyled">
                            <li>GP Transmission &amp; Auto Repair Inc.</li>
                            <li>47 Rue Vanier</li>
                            <li>Campbellton</li>
                            <li>E3N 1T8</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 contact-item-md">
                    <div class="business shadow-lg container h-100">
                        <div class="row text-center">
                            <h2 class="pb-0 mb-0">Business</h2>
                            <h2 class="pt-0 mt-0">Hours</h2>
                        </div>
                        <div class="row">
                            <div class="col text-end">MONDAY</div>
                            <div class="col">7:00-17:00</div>
                        </div>
                        <div class="row">
                            <div class="col text-end">TUESDAY</div>
                            <div class="col">7:00-17:00</div>
                        </div>
                        <div class="row">
                            <div class="col text-end">WEDNESDAY</div>
                            <div class="col">7:00-17:00</div>
                        </div>
                        <div class="row">
                            <div class="col text-end">THURSDAY</div>
                            <div class="col">7:00-17:00</div>
                        </div>
                        <div class="row">
                            <div class="col text-end">FRIDAY</div>
                            <div class="col">7:00-12:00</div>
                        </div>
                        <div class="row">
                            <div class="col text-end">SATURDAY</div>
                            <div class="col">CLOSED</div>
                        </div>
                        <div class="row">
                            <div class="col text-end">SUNDAY</div>
                            <div class="col">CLOSED</div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ADD APPOINTMENT --}}
            {{-- <div class="row align-items-center">
                <div class="col-md-12  contact-item-md" style="height: 150px;">
                    <button type="button"
                        class="btn btn-light border border-dark border-2 shadow-lg w-100 h-100 fs-1 rounded-pill appointment-button"><strong>CLICK
                            HERE TO
                            MAKE AN APPOINTMENT</strong></button>
                </div>
            </div> --}}
        </div>
    </div>
    <script type="module">
        // Click-to-load the Google Map (facade pattern) — no third-party JS until requested.
        document.querySelectorAll('.map-facade').forEach((facade) => {
            const btn = facade.querySelector('.map-facade-btn');
            if (!btn) return;
            btn.addEventListener('click', () => {
                const iframe = document.createElement('iframe');
                iframe.src = facade.dataset.mapSrc;
                iframe.className = 'w-100 h-100';
                iframe.style.border = '0';
                iframe.setAttribute('allowfullscreen', '');
                iframe.setAttribute('loading', 'lazy');
                iframe.setAttribute('referrerpolicy', 'no-referrer-when-downgrade');
                iframe.title = 'Map to GP Transmission, 47 Rue Vanier, Campbellton';
                facade.replaceChildren(iframe);
            });
        });
    </script>
@endsection