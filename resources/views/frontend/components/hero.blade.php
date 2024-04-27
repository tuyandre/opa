@php use App\Constants\VariableConstants; @endphp
<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">

    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
{{--                <h1>Office of Professional Auditors</h1>--}}
{{--                <h2>The power behind your progress</h2>--}}
                <h1>Check out Our Calender For Training Program</h1>
                <h2>stay updated with our work ,services, and offers by joining our mailing list today</h2>
                <div class="d-flex justify-content-center justify-content-lg-start">
                    <a href="{{route('frontend.pricing')}}" class="btn-get-started scrollto" style="background: #e50031">Comig Soon</a>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                <img src="{{asset(VariableConstants::ROOT_FOLDER.'assets/img/hero-img.png')}}" class="img-fluid animated" alt="">
            </div>
        </div>
    </div>

</section><!-- End Hero -->
