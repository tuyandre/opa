<!-- ======= Header ======= -->
<header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">

        <h1 class="logo me-auto"><a href="/">
                <img src="{{asset($ROOT_FOLDER.'assets/img/logo_black22.png')}}" >
            </a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="getstarted scrollto active" href="/">Home</a></li>
                <li><a class="getstarted scrollto" href="{{route('frontend.about.us')}}">About</a></li>
                <li><a class="getstarted scrollto" href="{{route('frontend.services')}}">Services</a></li>
{{--                <li><a class="nav-link   scrollto" href="#portfolio">Portfolio</a></li>--}}
{{--                <li><a class="nav-link scrollto" href="#team">Team</a></li>--}}
                <li><a class="getstarted scrollto" href="{{route('frontend.contact.us')}}">Contact</a></li>
                <li><a class="getstarted scrollto" href="{{route('frontend.pricing')}}">Training Registration </a></li>
                <li><a class="getstarted scrollto btn " style="background: black" href="{{route('login')}}">Staff Login </a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->
