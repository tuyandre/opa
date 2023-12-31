<!-- ======= Pricing Section ======= -->
<div  class="footer-newsletter" style="background: #146c77">
    <div class="container">
        <div class="row justify-content-center">
            <div class="section-title" style="height: 10vh">
           </div>
        </div>
    </div>
</div>
<section id="pricing" class="pricing" style="padding-top: 10px">
    <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2>Pricing</h2>
            <p>To be a reliable audit firm for SMEs with creative and innovative thoughts. Be with us for becoming professional Auditors ,Advanced excel expert and So on ... </p>
        </div>

        <div class="row">
            @foreach($training_sessions as $session)

            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="box featured">
                    <h3>{{$session->session_title}}</h3>
                    <h4>{{number_format($session->price)}}<sup>Rwf</sup>
{{--                        <span>{{$session->duration}}</span>--}}
                    </h4>

                    <div class="row mt-0" style="padding-top: 0 !important;">
                        <div class="col-sm-12" style="padding-top: 0 !important;">
                            <div class="card" style="padding-top: 0 !important;">
                                <div class="card-body pt-0 px-0">

                                    <div class="d-flex flex-row justify-content-between p-3 mid">
                                        <div class="d-flex flex-column">
                                            <small class="text-muted mb-1">START DATE</small>
                                            <div class="d-flex flex-row">
                                                <div class="d-flex flex-column ml-1">
                                                    <strong class="ghj">{{$session->start_date}}</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="mt-2 mx-3">
                                        <div class="d-flex flex-column">
                                            <small class="text-muted mb-2">END DATE</small>
                                            <div class="d-flex flex-row">
                                               <strong class="ghj">{{$session->end_date}}</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row justify-content-between p-3 mid">
                                        <div class="d-flex flex-column">
                                            <small class="text-muted mb-1">START TIME</small>
                                            <div class="d-flex flex-row">
                                                <div class="d-flex flex-column ml-1">
                                                    <strong class="ghj">{{$session->start_time}}</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <small class="text-muted mb-2">END TIME</small>
                                            <div class="d-flex flex-row">
{{--                                                <h6 class="ml-1">{{$session->end_time}}</h6>--}}
                                                <strong class="ghj">{{$session->end_time}}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between p-3 mid">
                                        <div class="d-flex flex-column">
                                            <strong class="text-muted mb-1 ghj">Attending Days</strong>
                                            <div class="d-flex flex-row">
                                                <div class="d-flex flex-column ml-1">
                                                    <span class="ghj">
                                                        {{$session->days}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between p-3 mid">
                                        <div class="d-flex flex-column">
                                            <strong class="text-muted mb-1 ghj">Summary</strong>
                                            <div class="d-flex flex-row">
                                                <div class="d-flex flex-column ml-1">
                                                    <span class="ghj">
                                                        {{$session->description}}
                                                    </span>
                                                </div>
                                            </div>
                                    </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <h3>Main Courses</h3>
                    <ul>
                        @foreach($services as $service)
                        <li><i class="bx bx-check"></i> {{$service->title}}</li>
                        @endforeach
                    </ul>
                    <a href="{{route('frontend.registration.training',$session->id)}}" class="buy-btn btn-contactus">Choose</a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section><!-- End Pricing Section -->
