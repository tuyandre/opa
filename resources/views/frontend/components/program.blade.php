<style>
    body {
        background: linear-gradient(to bottom, #e9f3f7, #cfe0e6);
        font-family: 'Segoe UI', sans-serif;
    }
    .program-card {
        background: #146c77;
        color: white;
        border-radius: 30px;
        padding: 2rem;
        margin: 1rem 0;
        box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        text-align: center;
    }
    .program-card-header {
        background: whitesmoke;
        padding: 1rem;
        border-radius: 30px;
        margin-bottom: 1rem;
        color: #146c77;
    }
    .program-card h5 {
        font-weight: bold;
    }
    .program-price {
        font-size: 1.0rem;
        margin: 1rem 0;
    }
    .program-features {
        text-align: left;
        margin: 1rem 0;
        padding-left: 0;
        list-style: none;
    }
    .program-features li::before {
        content: "✔ ";
        color: #e50031;
    }
    .btn-plan {
        background: #ff3c3c;
        border-radius: 50px;
        padding: 0.7rem 1.5rem;
        color: white;
        font-weight: bold;
        border: none;
    }
    .btn-plan:hover {
        background: #e50031;
    }
    .tab-nav {
        margin: 2rem 0;
    }
    .tab-nav .nav-link {
        border-radius: 50px;
        margin: 0 0.3rem;
        padding: 0.6rem 1.5rem;
        font-weight: bold;
        color: #fff;
        background: #146c77;
    }
    .tab-nav .nav-link.active {
        background: #e50031;
    }

</style>
<!-- ======= About Us Section ======= -->
<section id="about" class="about" style="border: whitesmoke; border-radius: 16px; box-shadow: 0 8px 15px rgba(0,0,0,0.2); margin-bottom: 30px; background: linear-gradient(to bottom, #e9f3f7, #cfe0e6);">
    <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2>TRAINING PROGRAM</h2>
        </div>
    </div>

    <div class="container py-1 text-center">
        <!-- Logo & Heading -->
{{--        <h2 class="fw-bold mb-4">TRAINING PROGRAM</h2>--}}

        <!-- Tabs -->
        <ul class="nav justify-content-center tab-nav">
            <li class="nav-item"><a class="nav-link " href="#">DAY</a></li>
            <li class="nav-item"><a class="nav-link" href="#">EVENING</a></li>
            <li class="nav-item"><a class="nav-link" href="#">SATURDAY</a></li>
        </ul>

        <!-- Program Cards -->
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="program-card">
                    <div class="text-center mb-3 program-card-header" >
                    <p> <strong>DAY </strong> <br>  <span>PROGRAM</span></p>
                    <p class="program-price">300,000 / Program</p>
                    </div>
                    <ul class="program-features">
                        <li>Practical accounting</li>
                        <li>Tax declaration</li>
                        <li>Quickbooks</li>
                        <li>Get ready for work</li>
                        <li>Professional advice</li>
                        <li>Career guidance</li>
                    </ul>
                    <a href="{{url("/training-registration")}}" class="btn btn-plan">SELECT PLAN <span style="color: whitesmoke"><i class="bx bx-chevron-right-circle"></i></span> </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="program-card">
                    <div class="text-center mb-3 program-card-header" >
                        <p> <strong>EVENING </strong> <br>  <span>PROGRAM</span></p>
                        <p class="program-price">300,000 / Program</p>
                    </div>

                    <ul class="program-features">
                        <li>Practical accounting</li>
                        <li>Tax declaration</li>
                        <li>Quickbooks</li>
                        <li>Get ready for work</li>
                        <li>Professional advice</li>
                        <li>Career guidance</li>
                    </ul>
                    <a href="{{url("/training-registration")}}" class="btn btn-plan">SELECT PLAN <span style="color: whitesmoke"><i class="bx bx-chevron-right-circle"></i></span> </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="program-card">
                    <div class="text-center mb-3 program-card-header" >
                        <p> <strong>SATURDAY </strong> <br>  <span>PROGRAM</span></p>
                        <p class="program-price">300,000 / Program</p>
                    </div>
                    <ul class="program-features">
                        <li>Practical accounting</li>
                        <li>Tax declaration</li>
                        <li>Quickbooks</li>
                        <li>Get ready for work</li>
                        <li>Professional advice</li>
                        <li>Career guidance</li>
                    </ul>
                    <a href="{{url("/training-registration")}}" class="btn btn-plan">SELECT PLAN <span style="color: whitesmoke"><i class="bx bx-chevron-right-circle"></i></span> </a>
                </div>
            </div>
        </div>
    </div>
</section><!-- End About Us Section -->
