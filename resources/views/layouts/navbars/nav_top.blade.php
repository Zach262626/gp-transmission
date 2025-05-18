{{-- To make nav bar remove fixed-top --}}
<nav class="navbar navbar-expand-lg navbar-light pt-2 d-none d-md-block" id="Navbar1">
    <div class="container d-flex border-bottom border-2 border-secondary align-middle ">
        <a class="navbar-brand d-none d-md-block" href="/">
            <img src="./img/Header.png" alt="" height="75">
        </a>
        @if ($type == "login")
            <div class="collapse navbar-collapse" id="navbarScroll1">
                <ul class="navbar-nav my-2 my-lg-0 ms-auto navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item mx-2 my-1">
                        <a class="fs-5 btn-nav-top" href="/signin">Sign In</a>
                    </li>
                </ul>
            </div>
        @elseif ($type == "signin")
            <div class="collapse navbar-collapse" id="navbarScroll1">
                <ul class="navbar-nav my-2 my-lg-0 ms-auto navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item mx-2 my-1">
                        <a class="fs-5 btn-nav-top" href="/login">Login In</a>
                    </li>
                </ul>
            </div>
        @else
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll1"
                aria-controls="navbarScroll1" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll1">
                <ul class="navbar-nav my-2 my-lg-0 ms-auto navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    @if ($type != 'contact')
                        <li class="nav-item mx-2 my-1">
                            <a class="fs-5 btn-nav-top" href="/contact">Service Request</a>
                        </li>
                    @endif
                    @auth
                        <li class="nav-item mx-2 my-1 ml-4">
                            <a class="fs-5 btn-nav-top" href="/telescope">telescope</a>
                        </li>
                        <li class="nav-item mx-2 my-1 ml-4">
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="fs-6 btn btn-primary">Logout</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        @endif
    </div>
</nav>
<nav class="navbar shadow-lg navbar-expand-lg fixed-top navbar-light pt-2" id="Navbar2"
    style="background-color:#d9d9d9ee; visibility: hidden">
    <div class="container px-3">
        <a class="navbar-brand" href="/">
            <img src="./img/Header.png" alt="" height="50">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll2"
            aria-controls="navbarScroll2" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        @if ($type == "login")
            <div class="collapse navbar-collapse" id="navbarScroll2">
                <ul class="navbar-nav my-2 my-lg-0 ms-auto navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="ml-2 nav-style-li" >
                        <a class="nav-link btn-nav mx-2 my-1" href="/signin">Sigin</a>
                    </li>
                </ul>
            </div>
        @elseif ($type == "signin")
            <div class="collapse navbar-collapse" id="navbarScroll2">
                <ul class="navbar-nav my-2 my-lg-0 ms-auto navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="ml-2 nav-style-li">
                        <a class="nav-link btn-nav mx-2 my-1" href="/login">Login</a>
                    </li>
                </ul>
            </div>
        @else
            <div class="collapse navbar-collapse" id="navbarScroll2">
                <ul class="navbar-nav my-2 my-lg-0 ms-auto navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="ml-2">
                        <a class="nav-link btn-nav mx-2 my-1" href="/">Home</a>
                    </li>
                    @auth
                        <li class="ml-2 nav-style-li" >
                            <a class="nav-link btn-nav mx-2 my-1" href="/telescope">telescope</a>
                        </li>
                        <li class="ml-2 nav-style-li" >
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="nav-link btn-nav mx-2 my-1">Logout</button>
                            </form>
                        </li>
                    @endauth
                    @if($type != 'contact')
                        <li class="ml-2 nav-style-li">
                            <a class="nav-link btn-nav mx-2 my-1 text-right" 
                                href="/contact">Service Request</a>
                        </li>
                    @endif
                    {{-- ADD APPOINTMENT --}}
                    {{-- <li class="ml-2">
                        <a class="nav-link btn-nav mx-2 my-1" href="#">Make an Appointment</a>
                    </li> --}}
                </ul>
            </div>
        @endif

    </div>
</nav>

<script type="module">
    // $(document).scrollTop(0);
    const navbar1 = document.querySelector("#Navbar1");
    const navbar2 = document.querySelector("#Navbar2");
    const navHeight = navbar2.getBoundingClientRect().height;
    var newPage = false;

    function updateNavColor(entries) {
        const [entry] = entries;
        if (!entry.isIntersecting) {
            if (!newPage) {
                navbar2.style.visibility = "visible";
                newPage = true;
            }
            navbar2.classList.remove("navbar-scrolldown");
            navbar2.classList.add("navbar-scrollup");
        } else {
            navbar2.style.visibility = "hidden"; // 👈 hide when back at top
            navbar2.classList.remove("navbar-scrollup");
            navbar2.classList.add("navbar-scrolldown");
            newPage = false; // 👈 reset flag so it can show again on next scroll
        }
    }


    const headerObserver = new IntersectionObserver(updateNavColor, {
        root: null,
        threshold: 0,
        rootMargin: `-${navHeight}px`
    });

    headerObserver.observe(navbar1)

</script>