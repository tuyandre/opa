<!-- ======= Portfolio Section ======= -->
@php use App\Constants\VariableConstants; @endphp
<section id="portfolio" class="portfolio">
    <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2>Our Gallery and Memories</h2>
            <p>
                Through our gallery, we celebrate milestones, team achievements, and the vibrant spirit of collaboration that defines us.
                It's a testament to the hard work, dedication,
                and creativity of our team members who contribute to our success story every day
            </p>
        </div>

        <ul id="portfolio-flters" class="d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active">All</li>
            <li data-filter=".filter-app">Our Student</li>
{{--            <li data-filter=".filter-card">Card</li>--}}
{{--            <li data-filter=".filter-web">Web</li>--}}
        </ul>

        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

            <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                <div class="portfolio-img"><img src="{{asset(VariableConstants::ROOT_FOLDER.'assets/img/web_2.jpg')}}" class="img-fluid" alt=""></div>
                <div class="portfolio-info">
                    <h4>Student </h4>
                    <p>With More collaboration</p>
                 </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                <div class="portfolio-img"><img src="{{asset(VariableConstants::ROOT_FOLDER.'assets/img/web_1.jpg')}}" class="img-fluid" alt=""></div>
                <div class="portfolio-info">
                    <h4>Student</h4>
{{--                    <p>Web</p>--}}
                </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                <div class="portfolio-img"><img src="{{asset(VariableConstants::ROOT_FOLDER.'assets/img/web_0.jpg')}}" class="img-fluid" alt=""></div>
                <div class="portfolio-info">
{{--                    <h4>App 2</h4>--}}
{{--                    <p>App</p>--}}
               </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                <div class="portfolio-img"><img src="{{asset(VariableConstants::ROOT_FOLDER.'assets/img/web_3.jpg')}}" class="img-fluid" alt=""></div>
                <div class="portfolio-info">
{{--                    <h4>Card 2</h4>--}}
{{--                    <p>Card</p>--}}
                 </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                <div class="portfolio-img"><img src="{{asset(VariableConstants::ROOT_FOLDER.'assets/img/web_2.jpg')}}" class="img-fluid" alt=""></div>
                <div class="portfolio-info">
{{--                    <h4>Web 2</h4>--}}
{{--                    <p>Web</p>--}}
                </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                <div class="portfolio-img"><img src="{{asset(VariableConstants::ROOT_FOLDER.'assets/img/web_4.jpg')}}" class="img-fluid" alt=""></div>
                <div class="portfolio-info">
{{--                    <h4>App 3</h4>--}}
{{--                    <p>App</p>--}}

                </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                <div class="portfolio-img"><img src="{{asset(VariableConstants::ROOT_FOLDER.'assets/img/web_3.jpg')}}" class="img-fluid" alt=""></div>
                <div class="portfolio-info">
{{--                    <h4>Card 1</h4>--}}
{{--                    <p>Card</p>--}}
               </div>
            </div>
        </div>

    </div>
</section><!-- End Portfolio Section -->
