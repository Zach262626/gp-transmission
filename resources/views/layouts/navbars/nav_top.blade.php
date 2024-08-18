@section('header')
    <style>
        /* secondary: #2F64AE */
        /* Light: #D9D9D9 */

        .navbar-scrolldown {
            transform: translate(0, -150px);
            transition: ease 500ms;
        }

        .navbar-scrollup {
            transition: ease 500ms;
        }

        .btn-nav {
            text-decoration: none;
        }

        .btn-nav-top {
            transition: ease 500ms;
            text-decoration: none;
            color: #2F64AE;
        }
        .btn-nav-top:hover {
            transition: ease 500ms;
            color: #D9D9D9;
        }
        .btn-nav-top:active {
            transition: ease 500ms;
            color: #2F64AE;
        }


        .navbar-nav .nav-link.active,
        .navbar-nav .nav-link:hover {
            color: black;
        }
    </style>
@endsection
{{-- To make nav bar remove fixed-top --}}
<nav class="navbar fixed-top navbar-expand-lg navbar-light  pt-2 " id="Navbar1">
    <div class="container d-flex border-bottom border-2 border-secondary align-middle">
        <a class="navbar-brand" href="#">
            <img src="./img/Header.png" alt="" height="75">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll1"
            aria-controls="navbarScroll1" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll1">
            <ul class="navbar-nav my-2 my-lg-0 ms-auto navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <li class="nav-item mx-2 my-1">
                    <a class="fs-5 btn-nav-top" href="#">Contact Us</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<nav class="navbar shadow-lg navbar-expand-lg fixed-top navbar-light pt-2 navbar-scrolldown" id="Navbar2"
    style="background-color:#d9d9d9ee;">
    <div class="container px-3">
        <a class="navbar-brand" href="#">
            <img src="./img/Header.png" alt="" height="50">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll2"
            aria-controls="navbarScroll2" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll2">
            <ul class="navbar-nav my-2 my-lg-0 ms-auto navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <li class="ml-2" style="border-right:1px solid rgba(0, 0, 0, 0.65)">
                    <a class="nav-link btn-nav mx-2 my-1" href="#">Home</a>
                </li>
                <li class="ml-2" >
                    <a class="nav-link btn-nav mx-2 my-1" href="#">Contact Us</a>
                </li>
                {{-- ADD APPOINTMENT --}}
                {{-- <li class="ml-2">
                    <a class="nav-link btn-nav mx-2 my-1" href="#">Make an Appointment</a>
                </li> --}}
            </ul>
        </div>
    </div>
</nav>
{{-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Navbar scroll</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarScroll">
        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Link
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Link</a>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav> --}}
@section('js')
    <script type="module">
        $(document).scrollTop(0);
        const navbar1 = document.querySelector("#Navbar1");
        document.addEventListener("scroll",
            () => {
                if (1 < window.scrollY) {
                    navbar1.classList.add("navbar-scrolldown");
                    navbar1.classList.remove("navbar-scrollup");
                } else {
                    navbar1.classList.add("navbar-scrollup");
                    navbar1.classList.remove("navbar-scrolldown");
                }
            }
        )
        const navbar2 = document.querySelector("#Navbar2");
        document.addEventListener("scroll",
            () => {
                if (1 < window.scrollY) {
                    navbar2.classList.remove("navbar-scrolldown");
                    navbar2.classList.add("navbar-scrollup");
                } else {
                    navbar2.classList.remove("navbar-scrollup");
                    navbar2.classList.add("navbar-scrolldown");
                }
            }
        )
        // function startNav() {
        //     if (window.innerHeight)
        // }
    </script>
@endsection
