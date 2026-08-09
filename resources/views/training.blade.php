@extends('frontend.layout.master')
@section('content')




    <!-- ======= Services Section ======= -->
    @include('frontend.components.training')
    <!-- End Services Section -->
    <!-- End Contact Section -->

@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
