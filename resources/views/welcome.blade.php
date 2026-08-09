@php use App\Constants\VariableConstants; @endphp
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
    @include('frontend.components.program')
    @include('frontend.components.partner')
    <!-- End Cliens Section -->

@endsection

@push('styles')
    <link href="{{asset(VariableConstants::ROOT_FOLDER.'assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{asset(VariableConstants::ROOT_FOLDER.'assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
@endpush
