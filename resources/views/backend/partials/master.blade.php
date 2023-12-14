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
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net-bs4/buttons.bootstrap4.css')}}">
{{--    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net-bs4/buttons.bootstrap4.min.css')}}">--}}
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net-bs4/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net-bs4/buttons.dataTables.css')}}">
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net-bs4/responsive.bootstrap4.css')}}">
{{--    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net-bs4/responsive.bootstrap4.min.css')}}">--}}
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset($ROOT_FOLDER.'/backend/assets/js/select.dataTables.min.css')}}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/css/vertical-layout-light/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset(url()->to('/').VariableConstants::ROOT_FOLDER.'/assets/img/sivicon.png')}}" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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

<!-- plugins:js -->
<script src="{{asset($ROOT_FOLDER.'/backend/assets/vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{asset($ROOT_FOLDER.'/backend/assets/vendors/chart.js/Chart.min.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
{{--<script src="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net-bs4/buttons.bootstrap4.js')}}"></script>--}}
<script src="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net-bs4/buttons.dataTables.min.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net-bs4/buttons.dataTables.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net-bs4/buttons.bootstrap4.min.js')}}"></script>
{{--<script src="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net-bs4/responsive.bootstrap4.js')}}"></script>--}}
<script src="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net-bs4/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'/backend/assets/js/dataTables.select.min.js')}}"></script>

<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{asset($ROOT_FOLDER.'/backend/assets/js/off-canvas.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'/backend/assets/js/hoverable-collapse.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'/backend/assets/js/template.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'/backend/assets/js/settings.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'/backend/assets/js/todolist.js')}}"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="{{asset($ROOT_FOLDER.'/backend/assets/js/dashboard.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'/backend/assets/js/Chart.roundedBarCharts.js')}}"></script>
<!-- End custom js for this page-->

@yield('scripts')

<script>
    $(document).ready(function() {
        $('#opa_tables').DataTable({
            "paging":   true,
            "ordering": true,
            "info":     true,
            "responsive": true,
            "buttons": [
                'copy', 'excel', 'pdf'
            ],
        });
    } );

</script>


</body>

</html>



