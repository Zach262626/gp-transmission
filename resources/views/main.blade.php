@extends('layouts.app', ['activePage' => 'MainPage', 'type' => 'main']) {{-- **IMPORTANT TO ADD activePage for styling** --}}

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
        "https://www.facebook.com/SgAutoTransmission",
        "https://g.co/kgs/itpTF2k"
      ]
    }
    </script>
@endsection

@section('content')
    <div id="Header">
        <picture>
            <source type="image/webp"
                srcset="{{ asset('img/cards/gptransmission-1280.webp') }} 1280w, {{ asset('img/cards/gptransmission.webp') }} 2000w"
                sizes="100vw">
            <img class="header_bg" src="{{ asset('img/cards/gptransmission.png') }}" alt="" width="2604"
                height="1398" fetchpriority="high" decoding="async">
        </picture>
        <div class="container">
            <div class="section_content row">
                <div class="col-12">
                    <h2 class="header_content-description">BEST SERVICE</h2>
                    <h2 class="header_content-description">IN THE</h2>
                    <h2 class="header_content-description">EAST COAST</h2>
                </div>
            </div>
            {{-- ADD APPOINTMENT --}}
            <div class="section_content row mt-5">
                <div class="col-12">
                    <form action="{{ route('contact') }}" method="get">
                        <button type="submit" class="btn shadow-lg h-100 fs-2 rounded appointment-button">
                            <strong>ENTER CUSTOMER INFORMATION HERE</strong>
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
                        <div class="main-item-description"><picture>
                                <source media="(max-width: 767.98px)" srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==">
                                <source type="image/webp" srcset="{{ asset('img/cards/tire.webp') }}">
                                <img class="header_bg" src="{{ asset('img/cards/tire.png') }}" alt="" width="800" height="800" loading="lazy" decoding="async">
                            </picture>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-2">
                        <h2 class="main-item-header">TRANSMISSIONS</h2>
                        <div class="main-item-description"><picture>
                                <source media="(max-width: 767.98px)" srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==">
                                <source type="image/webp" srcset="{{ asset('img/cards/car.webp') }}">
                                <img class="header_bg" src="{{ asset('img/cards/car.png') }}" alt="" width="800" height="400" loading="lazy" decoding="async">
                            </picture>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-4 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-3">
                        <h2 class="main-item-header">MOTOR VEHICLE INSPECTION</h2>
                        <div class="main-item-description"><picture>
                                <source media="(max-width: 767.98px)" srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==">
                                <source type="image/webp" srcset="{{ asset('img/cards/key.webp') }}">
                                <img class="header_bg" src="{{ asset('img/cards/key.png') }}" alt="" width="800" height="380" loading="lazy" decoding="async">
                            </picture>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-4">
                        <h2 class="main-item-header">OIL
                            CHANGES</h2>
                        <div class="main-item-description"><picture>
                                <source media="(max-width: 767.98px)" srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==">
                                <source type="image/webp" srcset="{{ asset('img/cards/oil.webp') }}">
                                <img class="header_bg" src="{{ asset('img/cards/oil.png') }}" alt="" width="800" height="1326" loading="lazy" decoding="async">
                            </picture>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-5">
                        <h2 class="main-item-header">BRAKES</h2>
                        <div class="main-item-description"><picture>
                                <source media="(max-width: 767.98px)" srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==">
                                <source type="image/webp" srcset="{{ asset('img/cards/pedals.webp') }}">
                                <img class="header_bg" src="{{ asset('img/cards/pedals.png') }}" alt="" width="800" height="524" loading="lazy" decoding="async">
                            </picture></div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center mb-5">
                <div class="col-md-7 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-6">
                        <h2 class="main-item-header">TUNE
                            UPS</h2>
                        <div class="main-item-description"><picture>
                                <source media="(max-width: 767.98px)" srcset="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==">
                                <source type="image/webp" srcset="{{ asset('img/cards/car2.webp') }}">
                                <img class="header_bg" src="{{ asset('img/cards/car2.png') }}" alt="" width="800" height="522" loading="lazy" decoding="async">
                            </picture>
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
    <div id="Contact">
        <div class="container my-5">
            <div class="row align-items-center">
                <div class="col-md-12 contact-item-md contact-map">
                    {{-- Map facade: defers loading the heavy Google Maps payload until the
                         visitor asks for it (click), keeping initial page load fast. --}}
                    <div class="h-100 map-facade"
                        data-map-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2669.5111874695913!2d-66.65408332358444!3d48.003833071229046!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4c982123f39f9b47%3A0x24d7005ac2504c44!2sGP%20Transmission%20%26%20Auto%20repair%20Inc.!5e0!3m2!1sen!2sca!4v1723596212599!5m2!1sen!2sca">
                        <button type="button" class="btn btn-light map-facade-btn w-100 h-100"
                            aria-label="Load map">
                            <strong><span aria-hidden="true">📍</span> View map</strong>
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
                        <div class="border-middle pb-2">e-mail:
                            <a href="mailto:sebgallant@hotmail.com" class="reach-us-link">sebgallant@hotmail.com</a>
                        </div>
                        <div class="fs-2">
                            <strong>Location</strong>
                        </div>
                        <ul class="list-unstyled">
                            <li>GP Transsmision</li>
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