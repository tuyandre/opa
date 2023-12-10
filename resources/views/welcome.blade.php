@extends('frontend.layout.master')
@section('hero')
    <!-- ======= Hero Section ======= -->
    @include('frontend.components.hero')
    <!-- End Hero -->
@endsection
@section('content')


    @include('frontend.components.aboutus')


    <!-- ======= Services Section ======= -->
    @include('frontend.components.services')
    <!-- End Services Section -->
    <!-- End Contact Section -->

    @include('frontend.components.contactus')

@endsection
