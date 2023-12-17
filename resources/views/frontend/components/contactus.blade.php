<!-- ======= Contact Section ======= -->
<section id="contact" class="contact">
    <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2>Contact</h2>
            <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="row">

            <div class="col-lg-5 d-flex align-items-stretch">
                <div class="info">
                    <div class="address">
                        <i class="bi bi-geo-alt"></i>
                        <h4>Location:</h4>
                        <p>Ziniya, Near World Food Program, Kicukiro- Kigali, Rwanda</p>
                    </div>

                    <div class="email">
                        <i class="bi bi-envelope"></i>
                        <h4>Email:</h4>
                        <p>info@opa.rw</p>
                    </div>

                    <div class="phone">
                        <i class="bi bi-phone"></i>
                        <h4>Call:</h4>
                        <p>+250 781 165 413 / +250 785 148 968</p>
                    </div>
                    <div style="width: 100%">
{{--                        <iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=300&amp;hl=en&amp;q=Ziniya%20Market+(Office%20of%20Professional%20Auditor)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>--}}
                        <iframe width="431" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" id="gmap_canvas" src="https://maps.google.com/maps?width=431&amp;height=300&amp;hl=en&amp;q=KK%2010%20Ave,%20uzi%20collection%20Kigali+(Office%20of%20Professional%20Auditor)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                    </div>

{{--                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>--}}
                </div>

            </div>

           <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">

                <form action="{{route('frontend.contact-us.store')}}" method="post" id="contactus_form" role="form" class="php-email-form">
                    @csrf
                    <div class="row">
                        <div class="form-group">

                            {{--                //get message from session--}}
                            @if(session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                            {{--                //get message from session--}}
                            @if(session()->has('error'))
                                <div class="alert alert-danger">
                                    {{ session()->get('error') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Your Name</label>
                            <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" id="full_name" required>

                            @error('full_name')
                            <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Your Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" required>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="telephone">Your Telephone</label>
                            <input type="tel" class="form-control @error('telephone') is-invalid @enderror" name="telephone" id="telephone" required>

                            @error('telephone')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">

                        <label for="name">Subject</label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" id="subject" required>

                        @error('subject')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Message</label>
                        <textarea class="form-control @error('message') is-invalid @enderror" name="message" rows="10" required></textarea>

                        @error('message')
                        <span class="invalid-feedback" role="alert">
                                        <strong >{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div class="text-center">
                        <input type="submit" class="btn btn-contactus" value="Send Message"/></div>
                </form>
            </div>

        </div>

    </div>
</section><!-- End Contact Section -->
