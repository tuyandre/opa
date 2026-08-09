<?php

    use App\Constants\VariableConstants;
    //get root url
    $main_url = url()->to('/');
    $ROOT_FOLDER =$main_url. VariableConstants::ROOT_FOLDER;

    ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>OPA|ADMIN</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'backend/assets/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'backend/assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'backend/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'backend/assets/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'backend/assets/css/vertical-layout-light/style.css')}}">
    <!-- endinject -->
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'backend/assets/css/dashboard-theme.css')}}">
    <link rel="shortcut icon" href="{{asset(url()->to('/').VariableConstants::ROOT_FOLDER.'assets/img/sivicon.png')}}" />

    {{-- DataTables CSS: only pushed by pages that render a #opa_tables table --}}
    @stack('datatables_styles')

</head>
<body>
<div class="container-scroller">
    @include('backend.partials._navbar')
    <div class="container-fluid page-body-wrapper">
        @include('backend.partials._settings-panel')
        @include('backend.partials._sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
{{--                //get session message--}}
                @if(session()->has('success'))
                    <div
                        class="alert alert-custom  my-3 alert-light-success border-success fade show rounded-sm"
                        role="alert">
                        <div class="alert-icon">
                            <i class="la la-check-circle"></i>
                        </div>
                        <div class="alert-text">
                            <span>{!! session()->get('success') !!}</span>
                        </div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="ki ki-close"></i></span>
                            </button>
                        </div>
                    </div>
            @endif
{{--            //get session error--}}
            @if(session()->has('error'))
                    <div
                        class="alert alert-custom  my-3 alert-light-danger border-danger fade show rounded-sm"
                        role="alert">
                        <div class="alert-icon">
                            <i class="flaticon-warning"></i>
                        </div>
                        <div class="alert-text">
                            <span>{{ session()->get('error') }}</span>
                        </div>
                        <div class="alert-close">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="ki ki-close"></i></span>
                            </button>
                        </div>
                    </div>
        @endif
                @if ($errors->any())
                    <div class="alert alert-danger rounded">
                        <div class="alert-icon">
                            <p>
                                <strong>Whoops!</strong> There were some problems with your input.
                            </p>
                        </div>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif



                @yield('content')
            </div>
            @include('backend.partials._footer')
        </div>

    <!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- plugins:js (bundles jQuery + Popper + Bootstrap JS) -->
<script src="{{asset($ROOT_FOLDER.'backend/assets/vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- inject:js -->
<script src="{{asset($ROOT_FOLDER.'backend/assets/js/off-canvas.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'backend/assets/js/hoverable-collapse.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'backend/assets/js/template.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'backend/assets/js/settings.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'backend/assets/js/todolist.js')}}"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="{{asset($ROOT_FOLDER.'backend/assets/js/dashboard.js')}}"></script>
<!-- End custom js for this page-->

{{-- DataTables JS: only pushed by pages that render a #opa_tables table --}}
@stack('datatables_scripts')

@yield('scripts')

<script>
    $(document).ready(function() {
        if ($('#opa_tables').length) {
            $('#opa_tables').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                buttons: [
                    'excelHtml5'
                ]
            });
        }
    } );

</script>


</body>

</html>



