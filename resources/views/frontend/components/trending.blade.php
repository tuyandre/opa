@php use App\Constants\VariableConstants;use App\Models\Trending; @endphp
    <!-- ======= Portfolio Details Section ======= -->
<section id="portfolio-details" class="portfolio-details">
    <div class="container">


        <div class="row gy-4">
            <?php

            $trends = Trending::where('is_active', 1)->limit(10)->orderBy('id', 'desc')->get();

            ?>


            <div class="col-lg-8">
                <div class="portfolio-details-slider swiper">
                    <div class="swiper-wrapper align-items-center">
                        @foreach($trends as $trend)

                            <div class="swiper-slide">
                                <img src="{{asset(VariableConstants::ROOT_FOLDER.$trend->image)}}" alt="">
                            </div>

                        @endforeach

                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="portfolio-details-slider swiper">
                    <div class="swiper-wrapper align-items-center">
                        @foreach($trends as $trend)
                            <div class="swiper-slide">
                                <div class="portfolio-description">
                                    <h2>{{$trend->title}}</h2>
                                    <p>
                                        {!! nl2br(e($trend->description)) !!}
                                    </p>

                                    {{--                    <a class="getstarted scrollto btn" style="background: black;color: white" href="{{route('frontend.trending.detail')}}">Read more</a>--}}
                                </div>
                            </div>
                        @endforeach

                    </div>
                    {{--                    <div class="swiper-pagination"></div>--}}
                </div>
            </div>


        </div>
        {{--        <div class="row gy-4">--}}

        {{--            <div class="col-lg-4">--}}
        {{--                <div class="portfolio-details-slider swiper">--}}
        {{--                    <div class="swiper-wrapper align-items-center">--}}
        {{--                        <div class="card">--}}
        {{--                            <div class="card-body">--}}
        {{--                                <div class="card-img">--}}
        {{--                                    <img src="{{asset(VariableConstants::ROOT_FOLDER.'assets/img/portfolio/portfolio-1.jpg')}}" alt="" style="width: 350px">--}}
        {{--                                </div>--}}
        {{--                                <h5 class="card-title">Card 1</h5>--}}
        {{--                                <p class="card-text">Some quick example text to build on the card title and make up the</p>--}}
        {{--                                <a href="#" class="btn btn-primary">Read More</a>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}


        {{--        </div>--}}


    </div>
</section><!-- End Portfolio Details Section -->
