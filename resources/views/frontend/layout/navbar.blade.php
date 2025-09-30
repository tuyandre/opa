<!-- ======= Header ======= -->


<header id="header" class="fixed-top">
    <div class="container    align-items-center counter_div" id="counter_div">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
{{--                    <div class="card-header text-white" style="background-color: #e50031">--}}
{{--                        <h6 class="mb-0 text-center">Registration Countdown Timer--}}

{{--                        </h6>--}}
{{--                    </div>--}}
                    <div class="card-body" style="height: 45px !important; padding: 5px !important; margin: 0 !important; background-color: #e50031">
                        <div class="row text-center">
                            <div class="col-2">
                                <p  class="display-7"><span id="days">00</span> Days</p>
                            </div>
                            <div class="col-2">
                                <p  class="display-7"><span id="hours">34</span> Hours</p>
                            </div>
                            <div class="col-2">
                                <p class="display-7"><span id="minutes">00</span> min</p>
                            </div>
                            <div class="col-2">
                                <p  class="display-7"><span id="seconds">00</span> Sec</p>
                            </div>
                            <div class="col-1">
                            </div>
                            <div class="col-3">
                             <a class="btn cta-btn align-middle" style="background-color: #146c70  !important; padding: 5px ; " href="{{route('frontend.registration.training')}}">Apply Now</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container d-flex align-items-center">

        <h1 class="logo me-auto"><a href="/">
                <img src="{{asset($ROOT_FOLDER.'assets/img/logo33.png')}}" >
            </a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="getstarted scrollto active" href="/">Home</a></li>
                <li><a class="getstarted scrollto" href="{{route('frontend.about.us')}}">About</a></li>
                <li><a class="getstarted scrollto" href="{{route('frontend.services')}}">Services</a></li>
                <li><a class="nav-link   scrollto" href="{{route('frontend.gallery')}}">Our Gallery</a></li>
                <li><a class="nav-link scrollto" href="{{route('frontend.team')}}">Our Team</a></li>
                <li><a class="getstarted scrollto" href="{{route('frontend.contact.us')}}">Contact</a></li>
                <li><a class="getstarted scrollto" href="{{route('frontend.pricing')}}">Training Program </a></li>
                <li><a class="getstarted scrollto btn " style="background: #e50031" href="{{route('login')}}">Staff Login </a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->
