<!DOCTYPE html>
<html lang="en">
<?php
use App\Constants\VariableConstants;

//    $ROOT_FOLDER = '/public/';
$main_url = url()->to('/');
$ROOT_FOLDER =$main_url.VariableConstants::ROOT_FOLDER;

?>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>OPA</title>
    <meta content="" name="Office of Professional Auditor">
    <meta content="" name="Office of Professional Auditor">

    <!-- Favicons -->
    <link href="{{asset($ROOT_FOLDER.'assets/img/sivicon.png')}}" rel="icon">
    <link href="{{asset($ROOT_FOLDER.'assets/img/sivicon.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts (loaded async so it doesn't block first render) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"></noscript>

    <!-- Vendor CSS Files (used on every page) -->
    <link href="{{asset($ROOT_FOLDER.'assets/vendor/aos/aos.css')}}" rel="stylesheet">
    <link href="{{asset($ROOT_FOLDER.'assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset($ROOT_FOLDER.'assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset($ROOT_FOLDER.'assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset($ROOT_FOLDER.'assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{asset($ROOT_FOLDER.'assets/css/style.css')}}" rel="stylesheet">
    <style>
      .align-items-stretch{
          margin-top: 10px;
          margin-bottom: 10px;
      }
      .bx-chevron-right{
          color: #eb0060 !important;
      }
    </style>

    <!-- Page-specific CSS (glightbox / swiper / select2 etc.), pushed only by pages that need them -->
    @stack('styles')

</head>

<body>

<!-- ======= Header ======= -->
@include('frontend.layout.navbar')
<!-- End Header -->

@yield('hero')

<main id="main">

    @yield('content')

</main>
    <!-- ======= Footer ======= -->
    @include('frontend.layout.footer')

    <!-- End Footer -->



<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files (used on every page) -->
<script src="{{asset($ROOT_FOLDER.'assets/vendor/aos/aos.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Page-specific JS (glightbox / isotope / swiper / select2 etc.), pushed only by pages that need them -->
@stack('scripts')

<!-- Template Main JS File -->
<script src="{{asset($ROOT_FOLDER.'assets/js/main.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'assets/js/counter.js')}}"></script>

<script type="text/javascript" src="{{ asset($ROOT_FOLDER.'vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>
<script type="text/javascript" src="{{ url($ROOT_FOLDER.'vendor/jsvalidation/js/jsvalidation.js')}}"></script>

<script>
    $(document).ready(function() {
        if ($.fn.select2) {
            $('.select2').select2({
                closeOnSelect: false
            });
        }
    });
    $(document).ready(function () {
        //validation
        $("#contactus_form").validate({
            rules: {
                full_name: {
                    required: true,
                    minlength: 5,
                    maxlength: 50,
                },
                email: {
                    required: true,
                    email: true,
                    minlength: 3,
                    maxlength: 50,
                },
                subject: {
                    required: true,
                    minlength: 3,
                    maxlength: 50,
                },
                message: {
                    required: true,
                    minlength: 10,
                    maxlength: 500,
                },
            },
            messages: {
                name: {
                    required: "Please enter your name",
                    minlength: "Your name must be at least 3 characters long",
                    maxlength: "Your name must be at least 50 characters long",
                },
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address",
                    minlength: "Your email must be at least 3 characters long",
                    maxlength: "Your email must be at least 50 characters long",
                },
                subject: {
                    required: "Please enter your subject",
                    minlength: "Your subject must be at least 3 characters long",
                    maxlength: "Your subject must be at least 50 characters long",
                },
                message: {
                    required: "Please enter your message",
                    minlength: "Your message must be at least 3 characters long",
                    maxlength: "Your message must be at least 50 characters long",
                },
            },
            submitHandler: function (form) {
                form.submit();
            },
        });
        //validation training_form
        $("#training_form").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 5,
                    maxlength: 50,
                },
                email: {
                    required: true,
                    email: true,
                    minlength: 3,
                    maxlength: 50,
                },
                company_tin: {
                    minlength: 9,
                    maxlength: 9,
                },
                telephone: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                },
                comment: {
                    required: true,
                    minlength: 2,
                    maxlength: 500,
                },
                password: {
                    required: true,
                    minlength: 8,
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password",
                },
            },
            messages: {
                name: {
                    required: "Please enter your name",
                    minlength: "Your name must be at least 3 characters long",
                    maxlength: "Your name must be at least 50 characters long",
                },
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address",
                    minlength: "Your email must be at least 3 characters long",
                    maxlength: "Your email must be at least 50 characters long",
                },
                telephone: {
                    required: "Please enter your telephone",
                    minlength: "Your telephone must be at least 10 characters long",
                    maxlength: "Your telephone must be at least 10 characters long",
                },
                company_tin: {
                    minlength: "Your company tin must be at least 9 characters long",
                    maxlength: "Your company tin must be at least 9 characters long",
                },
                comment: {
                    required: "Please enter your comment",
                    minlength: "Your comment must be at least 10 characters long",
                    maxlength: "Your comment must be at least 500 characters long",
                },
                password: {
                    required: "Please enter a password",
                    minlength: "Your password must be at least 8 characters long",
                },
                password_confirmation: {
                    required: "Please confirm your password",
                    equalTo: "Passwords do not match",
                },
            },
            submitHandler: function (form) {
                form.submit();
            },
        });

    });
</script>

</body>

</html>
