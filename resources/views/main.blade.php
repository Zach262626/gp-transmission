@extends('layouts.app', ['activePage' => 'MainPage']) {{-- **IMPORTANT TO ADD activePage for styling** --}}
@include('layouts.navbars.nav_top')

@section('content')
    <section id="Header">
        <img class="header_bg" src="./img/car-wallpaper.jpg" alt="car-wallpaper.jpg">
        <div class="container">
            <div class="section_content row">
                <div class="col-12">
                    <h2 class="header_content-description">BEST SERVICE</h2>
                    <h2 class="header_content-description">IN THE</h2>
                    <h2 class="header_content-description">EAST COAST</h2>
                </div>
            </div>
            <div class="section_content row mt-5">
                <div class="col-12 mt-5">
                    <button type="button"class="btn shadow-lg h-100 fs-2 rounded appointment-button">
                        <strong>BOOK AN APPOINTMENT HERE</strong>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section id="Main">
        <div class="container mt-4">
            <div class="row align-items-center">
                <div class="col-md-5 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-3">
                        <h2 class="main-item-header">TITLE</h2>
                        <div class="main-item-description">Everyone knows the importance of regular oil changes -
                            Precision Auto Tech can even set up a schedule for youthree columns</div>
                    </div>
                </div>
                <div class="col-md-7 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-4">
                        <h2 class="main-item-header">TITLE</h2>
                        <div class="main-item-description">Everyone knows the importance of regular oil changes -
                            Precision Auto Tech can even set up a schedule for youthree columns</div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-4 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-5">
                        <h2 class="main-item-header">TITLE</h2>
                        <div class="main-item-description">Everyone knows the importance of regular oil changes -
                            Precision Auto Tech can even set up a schedule for youthree columns</div>
                    </div>
                </div>
                <div class="col-md-4 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-6">
                        <h2 class="main-item-header">TITLE</h2>
                        <div class="main-item-description">Everyone knows the importance of regular oil changes -
                            Precision Auto Tech can even set up a schedule for youthree columns</div>
                    </div>
                </div>
                <div class="col-md-4 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-7">
                        <h2 class="main-item-header">TITLE</h2>
                        <div class="main-item-description">Everyone knows the importance of regular oil changes -
                            Precision Auto Tech can even set up a schedule for youthree columns</div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center mb-5">
                <div class="col-md-7 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-3">
                        <h2 class="main-item-header">TITLE</h2>
                        <div class="main-item-description">Everyone knows the importance of regular oil changes -
                            Precision Auto Tech can even set up a schedule for youthree columns</div>
                    </div>
                </div>
                <div class="col-md-5 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-4">
                        <h2 class="main-item-header">TITLE</h2>
                        <div class="main-item-description">Everyone knows the importance of regular oil changes -
                            Precision Auto Tech can even set up a schedule for youthree columns</div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    {{-- <section id="Review">
        <div class="owl-carousel">
            <div class="item">
                <div class="container border border-2 border-dark h-100">
                    @include('widgets.google_review')
                </div>
            </div>
            <div class="item"><h4>2</h4></div>
            <div class="item"><h4>3</h4></div>
            <div class="item"><h4>4</h4></div>
            <div class="item"><h4>5</h4></div>
            <div class="item"><h4>6</h4></div>
            <div class="item"><h4>7</h4></div>
            <div class="item"><h4>8</h4></div>
            <div class="item"><h4>9</h4></div>
            <div class="item"><h4>10</h4></div>
            <div class="item"><h4>11</h4></div>
            <div class="item"><h4>12</h4></div>
        </div>
    </section> --}}
    <section id="Contact">
        <div class="container my-5">
            <div class="row align-items-center">
                <div class="col-md-12 contact-item-md contact-map">
                    <div class="h-100">
                        <iframe class="w-100 h-100"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2669.5111874695913!2d-66.65408332358444!3d48.003833071229046!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4c982123f39f9b47%3A0x24d7005ac2504c44!2sGP%20Transmission%20%26%20Auto%20repair%20Inc.!5e0!3m2!1sen!2sca!4v1723596212599!5m2!1sen!2sca"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-md-6 contact-item-md">
                    <div class="reach-us shadow-lg border border-black border-1 container h-100">
                        <div class="fs-2">
                            <strong>HOW TO REACH US</strong>
                        </div>
                        <div>Phone: 999-777-1231</div>
                        <div class="border-middle pb-2">e-mail: sebgallant@hotmail.com</div>
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
            <div class="row align-items-center">
                <div class="col-md-12  contact-item-md" style="height: 150px;">
                    <button type="button"
                        class="btn btn-light border border-dark border-2 shadow-lg w-100 h-100 fs-1 rounded-pill appointment-button"><strong>CLICK
                            HERE TO
                            MAKE AN APPOINTMENT</strong></button>
                </div>
            </div>
        </div>
    </section>
    <script type="module">
        $(document).ready(function() {
            (function($) {
                $('.owl-carousel').owlCarousel({
                    padding: 5,
                    center: true,
                    items: 5,
                    loop: true,
                    //autoplay:true,
                    autoplayTimeout: 2000,
                    autoplayHoverPause: true,
                    animateOut: 'fadeOut'
                })
            })(jQuery);
        });
    </script>
    @include('layouts.footers.footer')
@endsection
