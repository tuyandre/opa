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
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset($ROOT_FOLDER.'/backend/assets/js/select.dataTables.min.css')}}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/css/vertical-layout-light/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset(url()->to('/').VariableConstants::ROOT_FOLDER.'/assets/img/logo_white.jpg')}}" />



    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"></script>
    <script src="{{asset($ROOT_FOLDER.'/backend/assets/DataTables/DataTables-1.13.8/css/dataTables.bootstrap4.min.css')}}"></script>
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/DataTables/Buttons-2.4.2/css/buttons.bootstrap4.min.css')}}">

    <!-- Plugin css for this page -->
{{--    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">--}}
{{--    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/DataTables/datatables.min.css')}}">--}}
{{--    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'/backend/assets/DataTables/Buttons-2.4.2/css/buttons.dataTables.css')}}">--}}


</head>
<body>
<div class="container-scroller">
    @include('backend.partials._navbar')
    <div class="container-fluid page-body-wrapper">
        @include('backend.partials._settings-panel')
        @include('backend.partials._sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
                @yield('content')
            </div>
            @include('backend.partials._footer')
        </div>

    <!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<script src="{{asset($ROOT_FOLDER.'/backend/assets/DataTables/jQuery-3.7.0/jquery-3.7.0.js')}}"></script>
<!-- plugins:js -->
<script src="{{asset($ROOT_FOLDER.'/backend/assets/vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{asset($ROOT_FOLDER.'/backend/assets/vendors/chart.js/Chart.min.js')}}"></script>
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

<script src="{{asset($ROOT_FOLDER.'/backend/assets/DataTables/DataTables-1.13.8/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'/backend/assets/DataTables/DataTables-1.13.8/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'/backend/assets/DataTables/Buttons-2.4.2/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'/backend/assets/DataTables/Buttons-2.4.2/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'/backend/assets/DataTables/Buttons-2.4.2/js/buttons.html5.min.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'/backend/assets/DataTables/Buttons-2.4.2/js/buttons.print.min.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'/backend/assets/DataTables/Buttons-2.4.2/js/buttons.colVis.min.js')}}"></script>








{{--<script src="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>--}}






{{--<script src="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>--}}
{{--<script src="{{asset($ROOT_FOLDER.'/backend/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.min.js')}}"></script>--}}
{{--<script src="{{asset($ROOT_FOLDER.'/backend/assets/DataTables/datatables.min.js')}}"></script>--}}
{{--<script src="{{asset($ROOT_FOLDER.'/backend/assets/DataTables/Buttons-2.4.2/js/buttons.dataTables.js')}}"></script>--}}
{{--<script src="{{asset($ROOT_FOLDER.'/backend/assets/js/dataTables.select.min.js')}}"></script>--}}


<!-- End custom js for this page-->

<script>
    $(document).ready(function() {
        // $('#opa_tables').DataTable({
        //     "paging":   true,
        //     "ordering": true,
        //     "info":     true,
        //     "responsive": true,
        //     "buttons": [
        //         'copy', 'excel', 'pdf'
        //     ],
        // });
        let table = $('#opa_tables').DataTable( {
            lengthChange: false,
            buttons: [ 'copy', 'excel' ]
        } );

        // table.buttons().container()
        //     .appendTo( '#example_wrapper .col-md-6:eq(0)' );
    } );

</script>


</body>

</html>



