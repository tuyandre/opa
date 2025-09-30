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

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset($ROOT_FOLDER.'assets/vendor/aos/aos.css')}}" rel="stylesheet">
    <link href="{{asset($ROOT_FOLDER.'assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset($ROOT_FOLDER.'assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset($ROOT_FOLDER.'assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset($ROOT_FOLDER.'assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{asset($ROOT_FOLDER.'assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{asset($ROOT_FOLDER.'assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

<!-- Vendor JS Files -->
<script src="{{asset($ROOT_FOLDER.'assets/vendor/aos/aos.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'assets/vendor/waypoints/noframework.waypoints.js')}}"></script>
{{--<script src="{{asset($ROOT_FOLDER.'assets/vendor/php-email-form/validate.js')}}"></script>--}}

<!-- Template Main JS File -->
<script src="{{asset($ROOT_FOLDER.'assets/js/main.js')}}"></script>
<script src="{{asset($ROOT_FOLDER.'assets/js/counter.js')}}"></script>


{{--<script src="{{asset($ROOT_FOLDER.'/backend/assets/DataTables/jQuery-3.7.0/jquery-3.7.0.js')}}"></script>--}}

<script type="text/javascript" src="{{ asset($ROOT_FOLDER.'vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>
<script type="text/javascript" src="{{ url($ROOT_FOLDER.'vendor/jsvalidation/js/jsvalidation.js')}}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            closeOnSelect: false
        });
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
            },
            submitHandler: function (form) {
                form.submit();
            },
        });

    });
</script>

<script>
    // Set the date we're counting down to (1 month from now)
    const countDownDate = new Date("October 6, 2025 00:00:00").getTime();

    // Update the countdown every 1 second
    const x = setInterval(function() {
        // Get today's date and time
        const now = new Date().getTime();

        // Find the distance between now and the countdown date
        const distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result
        document.getElementById("days").innerHTML = days.toString().padStart(2, '0') ;
        document.getElementById("hours").innerHTML = hours.toString().padStart(2, '0');
        document.getElementById("minutes").innerHTML = minutes.toString().padStart(2, '0');
        document.getElementById("seconds").innerHTML = seconds.toString().padStart(2, '0');

        // If the countdown is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("days").innerHTML = "00";
            document.getElementById("hours").innerHTML = "00";
            document.getElementById("minutes").innerHTML = "00";
            document.getElementById("seconds").innerHTML = "00";
            //remove apply now button and whole div
            const ctaDiv = document.querySelector('.counter_div');
            if (ctaDiv) {
                //add hidden class
                ctaDiv.style.display = 'none';
            }
        }
    }, 1000);
</script>
</body>

</html>
