@extends('frontend.layout.master')
@section('hero')
    <!-- ======= Hero Section ======= -->
    @include('frontend.components.hero')
    <!-- End Hero -->
@endsection
@section('content')


    @include('frontend.components.trending')

    @include('frontend.components.performance')
    
    @include('frontend.components.aboutus')

{{--    @include('frontend.components.contactus')--}}

    <!-- ======= Clients Section ======= -->
    @include('frontend.components.partner')
    <!-- End Cliens Section -->

@endsection
