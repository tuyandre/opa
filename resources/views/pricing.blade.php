@php use App\Constants\VariableConstants; @endphp
@extends('frontend.layout.master')
<style>
    /* Keep a classic serif appearance similar to the screenshot */
    body { font-family: Georgia, 'Times New Roman', serif; color: #111; }
    .label { font-weight: 700; }
    .value { font-weight: 500; margin-left: 6px; }


    /* Card styling */
    .brochure-card { border: none; }
    .section-title { font-size: 1.05rem; font-weight: 700; margin-bottom: .6rem; }


    /* Weekly overview table subtle look */
    .overview .table { margin-bottom: 0; }
    .overview .week { padding: .45rem 0; }

    .apply-button{
        background-color: #ff3c3c !important;
        border-radius: 50px;
        padding: 0.7rem 1.5rem;
        color: white;
        font-weight: bold;
        border: none;
        text-decoration: none;

    }


    /* Fine typography adjustments */
    h1, h2, h3, h4 { font-family: Georgia, 'Times New Roman', serif; }
    ul li{
        list-style-type: none;
    }


    /* Responsive tweaks */
    @media (max-width: 576px) {
        .two-col .col-sm-6 { margin-bottom: .6rem; }
    }
</style>
@section('hero')
    <section id="hero" class="d-flex align-items-center" style="height: 40vh !important;">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                    <h1>Apply</h1>

                </div>
                {{-- <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                    <img src="{{asset(VariableConstants::ROOT_FOLDER.'assets/img/web_0.jpg')}}" style="height: 80%" class="img-fluid animated"  alt="">
                </div> --}}
            </div>
        </div>

    </section>
@endsection
@section('content')
    <!-- ======= Why Us Section ======= -->
    <section id="why-us" class="why-us section-bg">
        <div class="container-fluid" data-aos="fade-up">

            <div class="row">

                <div class="col-lg-12 d-flex flex-column justify-content-center align-items-stretch  order-1 order-lg-1">

                    <div class="content">
                        <h3><strong>15-Day OPA Accounting Training Program </strong></h3>
                        <p>
                            This 15-days intensive training program is tailored for fresh graduates and individuals aiming to build strong accounting skills.
                            The course focuses on three core areas: Tax Declaration, QuickBooks, and Practical Accounting. By combining theory with hands-on exercises,
                            participants will gain the confidence and practical skills required to thrive in an accounting role in Rwanda. Each session is designed to progressively develop technical expertise,
                            ensure compliance with local regulations, and provide exposure to real-life accounting practices</p>
                    </div>
                    <!-- Basic info lines -->
                    <div class="content">
                    <div class="row two-col mb-3">
                        <div class="col-sm-12">
                            <div><span class="label">Location:</span><span class="value">OPA Training Office, Kicukiro Ziniya Near World Food Program</span></div>
                            <div class="mt-1"><span class="label">Duration:</span><span class="value">15 Days</span></div>
                            <div class="mt-1"><span class="label">Days Per Week:</span><span class="value">2 Days, 6 Hours Per Week</span></div>

                            <div><span class="label">Hours per Day:</span><span class="value">3 hours</span></div>
                            <div class="mt-1"><span class="label">Target Audience:</span><span class="value">New recruits, junior accountants, or upskilling staff</span></div>
                        </div>
                    </div>
                    <hr>

                        <!-- Weekly Overview -->
                        <div class="overview mb-3">
                            <div class="section-title"><i class="bi bi-journal-text me-2"></i>Weekly Overview</div>


                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                    <tr>
                                        <th style="width:18%;">Week</th>
                                        <th>Focus Area</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="week">Week 1</td>
                                        <td>Practical Accounting Fundamentals</td>
                                    </tr>
                                    <tr>
                                        <td class="week">Week 2</td>
                                        <td>QuickBooks (Desktop or Online)</td>
                                    </tr>
                                    <tr>
                                        <td class="week">Week 3</td>
                                        <td>Rwandan Tax Declaration &amp; Compliance</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>

                        <!-- Detailed Training Plan -->
                        <div class="detailed-plan">
                            <div class="section-title">Detailed Training Plan</div>


                            <h5 class="mt-3">Phase 1: Practical Accounting Knowledge (Days 1–5)</h5>
                            <p class="mb-1"><strong>Goal:</strong> Build a strong foundation in accounting principles, the accounting cycle, financial statements, and real-world application.</p>
                            <ul>
                                <li>Day 1: Introduction to accounting principles &amp; double-entry bookkeeping.</li>
                                <li>Day 2: Chart of accounts and journals.</li>
                                <li>Day 3: Ledgers, trial balance, and adjustments.</li>
                                <li>Day 4: Preparation of financial statements (income statement, balance sheet).</li>
                                <li>Day 5: Practical exercises and real-world case study.</li>
                            </ul>


                            <h5 class="mt-3">Phase 2: QuickBooks Training (Days 6–10)</h5>
                            <p class="mb-1"><strong>Goal:</strong> Equip trainees with the ability to use QuickBooks for daily accounting tasks, financial reporting, and system set up and customization.</p>
                            <ul>
                                <li>Day 6: Introduction to QuickBooks, charts of accounts, creating items, and use of journals entry.</li>
                                <li>Day 7: Customers, Sales, and Receivables.</li>
                                <li>Day 8: Suppliers, Expenses, and Payables.</li>
                                <li>Day 9: Banking, Reconciliations, and Payroll Basics.</li>
                                <li>Day 10: Financial Reporting & Customization.</li>
                            </ul>


                            <h5 class="mt-3">Phase 3: Rwanda Tax Compliance and Declarations (Days 11–15)</h5>
                            <p class="mb-1"><strong>Goal:</strong> Understand Rwanda’s tax system, how to prepare and submit tax declarations, and ensure compliance using real data.</p>
                            <ul>
                                <li>Day 11: Overview of Rwanda’s Taxes, types and overview.</li>
                                <li>Day 12: Value Added Tax (VAT).</li>
                                <li>Day 13: Pay As You Earn (PAYE) and Withholding Tax.</li>
                                <li>Day 14: Corporate Income Tax (CIT), Personal Income Tax (PIT) and IQP.</li>
                                <li style="color: #e50031"> <strong>Day 15: Practical exercises using real data and final assessment</strong></li>
                            </ul>
                            <!-- Trainee Support Materials -->
                            <h5 class="mt-4">Trainee Support Materials</h5>
                            <ul>
                                <li><i class="ri-check-double-line"></i> Computers with QuickBooks installed (Desktop version)</li>
                                <li><i class="ri-check-double-line"></i> Internet access all the time</li>
                                <li><i class="ri-check-double-line"></i> Sample business documents (invoices, receipts, payroll sheets)</li>
                                <li><i class="ri-check-double-line"></i> Handouts: Rwanda tax guide, QuickBooks short manual, accounting cheat sheets</li>
                            </ul>

                            <!-- Certification -->
                            <h5 class="mt-4"><i class="bi bi-award-fill me-2 text-primary"></i>Certification</h5>
                            <p>Participants who complete all sessions and pass the final assessment with 80% minimum pass receive a <strong>Certificate of Completion in Practical Accounting &amp; Tax Compliance (Rwanda).</strong></p>
                        </div>
                        <hr>
                        <div class="text-center mb-3">
                            <a class="btn btn-primary apply-button" href="{{route('frontend.registration.training')}}">Apply Now</a>

                        </div>

                    </div>

                </div>
                @if($is_registration_open)
{{--                    <div class="col-lg-2">--}}
{{--                        <a class="btn  apply-button" href="{{route('frontend.registration.training')}}">Apply Now</a>--}}
{{--                    </div>--}}
                @endif

            </div>

        </div>
    </section><!-- End Why Us Section -->


@endsection
