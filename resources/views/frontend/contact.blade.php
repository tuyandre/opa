@php use App\Constants\VariableConstants; @endphp
@extends('frontend.layout.master')
@section('hero')
    <section id="hero" class="d-flex align-items-center" style="height: 40vh !important;">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                    <h1>Contact Us</h1>

                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                    <img src="{{asset(VariableConstants::ROOT_FOLDER.'assets/img/web_1.jpg')}}" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>

    </section>
@endsection
@section('content')



    @include('frontend.components.contactus')

    <!-- ======= Clients Section ======= -->
    @include('frontend.components.partner')
    <!-- End Cliens Section -->

@endsection
