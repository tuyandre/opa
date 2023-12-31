<!-- ======= Clients Section ======= -->
<section id="clients" class="clients section-bg">
    <div class="container">

        <div class="row" data-aos="zoom-in">
            <?php
            $partners = \App\Models\Partner::where('is_active',true)->get();
            ?>
            @foreach($partners as $partner)


            <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
                <img src="{{asset($partner->logo)}}" class="img-fluid" alt="">
            </div>

            @endforeach


        </div>

    </div>
</section><!-- End Cliens Section -->
