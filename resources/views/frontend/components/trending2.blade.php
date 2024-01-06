@php use App\Constants\VariableConstants; @endphp
<!-- ======= Portfolio Details Section ======= -->
<section id="portfolio-details" class="portfolio-details">
    <div class="container">

        <div class="row gy-4">

            <div class="col-lg-6">
                <div class="portfolio-details-slider swiper">
                    <div class="swiper-wrapper align-items-center">

                        <div class="swiper-slide">
                            <img src="{{asset(VariableConstants::ROOT_FOLDER.'assets/img/portfolio/portfolio-1.jpg')}}" alt="">
                        </div>

                        <div class="swiper-slide">
                            <img src="{{asset(VariableConstants::ROOT_FOLDER.'assets/img/portfolio/portfolio-2.jpg')}}" alt="">
                        </div>

                        <div class="swiper-slide">
                            <img src="{{asset(VariableConstants::ROOT_FOLDER.'assets/img/portfolio/portfolio-3.jpg')}}" alt="">
                        </div>

                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>

            <div class="col-lg-6">
{{--                <div class="portfolio-info">--}}
{{--                    <h3>Project information</h3>--}}

{{--                </div>--}}
                <div class="portfolio-description">
                    <h2>This is an example of portfolio detail</h2>
                    <p>
                        Autem ipsum nam porro corporis rerum. Quis eos dolorem eos itaque inventore commodi labore quia quia. Exercitationem repudiandae officiis neque suscipit non officia eaque itaque enim. Voluptatem officia accusantium nesciunt est omnis tempora consectetur dignissimos. Sequi nulla at esse enim cum deserunt eius.
                    </p>

{{--                    <a class="getstarted scrollto btn" style="background: black;color: white" href="{{route('frontend.trending.detail')}}">Read more</a>--}}
                </div>
            </div>

        </div>

    </div>
</section><!-- End Portfolio Details Section -->
