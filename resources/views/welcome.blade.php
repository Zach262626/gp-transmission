<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    @vite(['resources/scss/app.scss'])
</head>

<body>
    {{-- To make nav bar remove fixed-top --}}
    <nav class="navbar fixed-top navbar-light">
        <div class="container border-bottom border-secondary border-2 pt-2">
            <a class="navbar-brand" href="#">
                <img src="./img/Header.png" alt="" height="75">
            </a>
        </div>
    </nav>
    <section id="Header">
        <img class="header_bg" src="./img/car-wallpaper.jpg" alt="car-wallpaper.jpg">
        <div class="container">
            <div class="section_content text-end">
                <h2 class="header_content-description">BEST</h2>
                <h2 class="header_content-description">SERVICE IN</h2>
                <h2 class="header_content-description">EAST</h2>
                <h2 class="header_content-description">COAST</h2>
            </div>
        </div>
    </section>
    <section id="Main">
        <div class="container mt-4">
            <div class="row align-items-center mt-3">
                <div class="col-9 p-2 ">
                    <div class="main-item-md shadow-lg" id="main-item-1">
                        <h2 class="main-item-header">Title</h2>
                        <div class="main-item-description">Everyone knows the importance of regular oil changes -
                            Precision Auto Tech can even set up a schedule for youthree columns</div>
                    </div>
                </div>
                <div class="col-3 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-2">
                        <h2 class="main-item-header">Title</h2>
                        <div class="main-item-description">Everyone knows the importance of regular oil changes -
                            Precision Auto Tech can even set up a schedule for youthree columns</div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-5 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-3">
                        <h2 class="main-item-header">Title</h2>
                        <div class="main-item-description">Everyone knows the importance of regular oil changes -
                            Precision Auto Tech can even set up a schedule for youthree columns</div>
                    </div>
                </div>
                <div class="col-7 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-4">
                        <h2 class="main-item-header">Title</h2>
                        <div class="main-item-description">Everyone knows the importance of regular oil changes -
                            Precision Auto Tech can even set up a schedule for youthree columns</div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center mb-5">
                <div class="col-4 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-5">
                        <h2 class="main-item-header">Title</h2>
                        <div class="main-item-description">Everyone knows the importance of regular oil changes -
                            Precision Auto Tech can even set up a schedule for youthree columns</div>
                    </div>
                </div>
                <div class="col-4 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-6">
                        <h2 class="main-item-header">Title</h2>
                        <div class="main-item-description">Everyone knows the importance of regular oil changes -
                            Precision Auto Tech can even set up a schedule for youthree columns</div>
                    </div>
                </div>
                <div class="col-4 p-2">
                    <div class="main-item-md shadow-lg" id="main-item-7">
                        <h2 class="main-item-header">Title</h2>
                        <div class="main-item-description">Everyone knows the importance of regular oil changes -
                            Precision Auto Tech can even set up a schedule for youthree columns</div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <section id="Contact">
        <div class="container my-5">
            <div class="row align-items-center">
                <div class="col-12 contact-item-md">
                    <div class="">

                    </div>
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-6 contact-item-md">
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
                <div class="col-6 contact-item-md">
                    <div class="business shadow-lg container h-100">
                        <div class="row text-center">
                            <h2 class="pb-0 mb-0">Business</h2>
                            <h2 class="pt-0 mt-0">Hours</h2>
                        </div>
                        <div class="row">
                            <div class="col text-end">MONDAY</div>
                            <div class="col">8:00-17:00</div>
                        </div>
                        <div class="row">
                            <div class="col text-end">TUESDAY</div>
                            <div class="col">8:00-17:00</div>
                        </div>
                        <div class="row">
                            <div class="col text-end">WEDNESDAY</div>
                            <div class="col">8:00-17:00</div>
                        </div>
                        <div class="row">
                            <div class="col text-end">THURSDAY</div>
                            <div class="col">8:00-17:00</div>
                        </div>
                        <div class="row">
                            <div class="col text-end">FRIDAY</div>
                            <div class="col">8:00-12:00</div>
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
                {{-- <div class="business-hours">
                        <h2 class="title p-4">Business Hours</h2>
                        <div class="container">
                            <ul class="row list-unstyled p-2 opening-hour">
                                <li class="col-6 text-end">MONDAY</li>
                                <li class="col-6">8:00-17:00</li>
                                <li class="col-6 text-end">TUESDAY</li>
                                <li class="col-6">8:00-17:00</li>
                                <li class="col-6 text-end">WEDNESDAY</li>
                                <li class="col-6">8:00-17:00</li>
                                <li class="col-6 text-end">THURSDAY</li>
                                <li class="col-6">8:00-17:00</li>
                                <li class="col-6 text-end">FRIDAY</li>
                                <li class="col-6">8:00-17:00</li>
                            </ul>
                        </div>
                    </div> --}}
            </div>
            <div class="row align-items-center">
                <div class="col-12  contact-item-md" style="height: 150px;">
                    <button type="button" class="btn btn-secondary shadow-lg w-100 h-100 fs-1 appointment"><strong>CLICK HERE TO
                            MAKE AN APPOINTMENT</strong></button>
                </div>
            </div>
        </div>
    </section>
    <section id="Footer" class="" style="height: 150px;">
    </section>
    @vite(['resources/js/app.js'])
</body>

</html>
