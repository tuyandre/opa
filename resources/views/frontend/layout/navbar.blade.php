<!-- ======= Header ======= -->
<style>
    #countdown-bar {
        background: #e50031;
        color: #fff;
        font-weight: 600;
        padding: 5px 0;
        display: flex;
        justify-content: center;
    }
    #countdown h4 {
        margin: 0 0px;
        font-size: 1.1rem;
    }

    /* Smooth pulse animation */
    .btn-animate {
        transition: transform 0.2s ease-in-out;
        background-color: white;
        color: #e50031;
        border: 2px solid #e50031;
        font-weight: bold;
        border-radius: 20px;

    }

    /* Hover grow */
    .btn-animate:hover {
        transform: scale(1.1);
        background-color: #146c77;
        color: white;
    }

    /* Click shrink */
    .btn-animate:active {
        transform: scale(0.95);
    }

    /* Optional: continuous pulsing effect */
    .btn-pulse {
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.20); }
        100% { transform: scale(1); }
    }
</style>


<header id="header" class="fixed-top" style="margin-top: 0 !important; padding-top: 0 !important; ">

    <div id="countdown-bar" class="position-relative text-center mb-3">

        <h4 class="mb-0" id="countdowns"></h4>
        <a href="{{url("/training-registration")}}" class="btn btn-primary btn-sm btn-animate btn-pulse position-absolute end-0 top-50 translate-middle-y">Apply Now</a>
    </div>
{{--    <div class="container    align-items-center counter_div" id="counter_div">--}}
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header text-white" style="background-color: #e50031">--}}
{{--                        <h6 class="mb-0 text-center">Registration Countdown Timer--}}

{{--                        </h6>--}}
{{--                    </div>--}}
{{--                    <div class="card-body" style="height: 45px !important; padding: 5px !important; margin: 0 !important; background-color: #e50031">--}}
{{--                        <div class="row text-center">--}}
{{--                            <div class="col-2">--}}
{{--                                <p  class="display-7"><span id="days">00</span> Days</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-2">--}}
{{--                                <p  class="display-7"><span id="hours">34</span> Hours</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-2">--}}
{{--                                <p class="display-7"><span id="minutes">00</span> min</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-2">--}}
{{--                                <p  class="display-7"><span id="seconds">00</span> Sec</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-1">--}}
{{--                            </div>--}}
{{--                            <div class="col-3">--}}
{{--                             <a class="btn cta-btn align-middle" style="background-color: #146c70  !important; padding: 5px ; " href="{{route('frontend.registration.training')}}">Apply Now</a>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

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
