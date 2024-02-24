@php use App\Constants\VariableConstants; @endphp
@extends('frontend.layout.master')
@section('hero')
    <section id="hero" class="d-flex align-items-center" style="height: 40vh !important;">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                    <h1>Apply</h1>

                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                    <img src="{{asset(VariableConstants::ROOT_FOLDER.'assets/img/hero-img.png')}}" class="img-fluid animated"  alt="">
                </div>
            </div>
        </div>

    </section>
@endsection
@section('content')
    <!-- ======= Why Us Section ======= -->
    <section id="why-us" class="why-us section-bg">
        <div class="container-fluid" data-aos="fade-up">

            <div class="row">

                <div class="col-lg-7 d-flex flex-column justify-content-center align-items-stretch  order-2 order-lg-1">

                    <div class="content">
                        <h3><strong>Be a professional trainee in OPA </strong></h3>
                        <p>
                            With the support of certified professional accountants, OPA offer a variety of training options to enhance the efficiency in the organization. We are committed to efficiency, compliance,
                            reliability and suitability of the accounting information which leads to the profitability or the organization as a whole.
                        </p>
                    </div>
                    <div class="content">
                        <h2 ><strong>Training offered.</strong></h2>
                        <hr>
                        <h4><strong>Training in tax declaration </strong></h4>
                        <p>
                            The trainee will get hands on experience and knowledge in declaration of taxes applicable in Rwanda,
                            tax planning mechanisms available to the institution in regards to the tax laws,
                            and the ability to maintain the tax records which useful in different purposes.
                        </p>
                        <h4><strong>Training in general practical accounting.  </strong></h4>
                        <p>
                            According to <strong>FINPROV</strong>, “Accounting is a language of the business”. We need the proper accounting records to better
                            communicate the financial performance and the financial position of the business. For the accounting to portray the true and fair
                            view image of the business, it should be prepared by the people who understand the accounting process. In OPA,
                            we help the trainees understand the process of accounting which includes identifying, classing, recording, summarizing,
                            and reporting the financial data so that he/she can be able to communicate the business image.
                        </p>
                        <h4><strong>Training in Excel and accounting software (QuickBooks).</strong></h4>
                        <p>
                            In Rwanda, a business with annual turnover exceeding 20 Million is obliged to keep books of accounts.
                            You can’t manage the books of accounts without the knowledge of about excel and accounting software.
                            OPA is the best place where you will meet the professionals to help you understand the whole process.
                        </p>
                        <p>The training is planned in the way that everyone is included. If you are working and ends to the work at 5Pm,
                            there is a session for you<strong> Monday to Friday from 5:30Pm to 8:30Pm </strong>or just <strong> Saturday 8:30Am to 12:30Am.</strong>
                            So, don’t hesitate to reach to us </p>

                    </div>

                </div>

                <div class="col-lg-5 align-items-stretch order-1 order-lg-2 img" style='background-image: url("assets/img/why-us.png");' data-aos="zoom-in" data-aos-delay="150">&nbsp;</div>
            </div>

        </div>
    </section><!-- End Why Us Section -->
    <section id="about" class="about">
        <div class="container" data-aos="fade-up">

            <div class="row content">
                <div class="col-lg-8">
                    <div class="text-center">
                        <h3>Admission Criteria</h3>
                    </div>
                    <ul>
                        <li><i class="ri-check-double-line"></i> Prior accounting and business knowledge</li>
                        <li><i class="ri-check-double-line"></i> Have completed university studies</li>
                        <li><i class="ri-check-double-line"></i> Strong interest in business, accounting and taxation</li>
                        <li><i class="ri-check-double-line"></i> English skills</li>
                        <li><i class="ri-check-double-line"></i> Advance payment and committed to pay full amount before completion of the program</li>
                        <li><i class="ri-check-double-line"></i> Valid ID/Passport</li>
                        <li><i class="ri-check-double-line"></i> Committed to attend every time per the plan time table</li>
                    </ul>
                </div>
            </div>

        </div>
    </section><!-- End About Us Section -->


    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
        <div class="container" data-aos="zoom-in">

            <div class="row">
                <div class="col-lg-9 text-center text-lg-start">
                    <h3>Training Fees</h3>
                    <p>– For a period of 1 month and half (1.5Months), the training fee is 200,000 RWF inclusive of VAT payable in advance prior to joining the training. This fee covers the access to the training space and materials, all the program support, internet access, etc. </p>
                    <p>– The registration is free of charge. If you see someone asking for registration fees, you are advised to report the case immediately to OPA to avoid any. </p>
                    <p>– Upon negotiation, the instalments payment is acceptable but not exceeding the 3rd week of the training period.  </p>
                    <p>All the amounts should be paid to the company account number: 4002201067147 RWF in Equity Bank or USD Account Number: 4012201079486 registered for Office of Professional Auditors Ltd. Or MTN MOMO CODE: 012300</p>
                </div>
                <div class="col-lg-3 cta-btn-container text-center">
                    <a class="cta-btn align-middle" href="{{route('frontend.registration.training')}}">Apply Now</a>
                </div>
            </div>

        </div>
    </section><!-- End Cta Section -->

@endsection
