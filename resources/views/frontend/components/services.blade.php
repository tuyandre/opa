<!-- ======= Services Section ======= -->
<section id="services" class="services section-bg">
    <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2>Services</h2>
            <p>These services help businesses and individuals navigate the complexities of financial management, regulatory compliance, and taxation, ensuring both legal compliance and financial optimization</p>
        </div>

        <div class="row" style="margin: 20px !important;">
            <div class="col-xl-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                <div class="icon-box">
                    <div class="icon"><i class="bx bxl-dribbble"></i></div>
                    <h4><a href="">Tax Consultancy Services</a></h4>
                    <p>
                        Tax consultancy services involve providing professional advice and assistance to individuals, businesses, and organizations to navigate the complexities of tax laws, regulations, and obligations. Tax consultants, often experts in tax law and accounting, help their clients optimize their financial situations while ensuring compliance with applicable tax laws.
                    </p>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
                <div class="icon-box">
                    <div class="icon"><i class="bx bx-file"></i></div>
                    <h4><a href="">Business Consulting Services</a></h4>
                    <p>
                        Business consulting services encompass a range of professional advisory services aimed at helping businesses improve their performance, efficiency, and overall success. Business consultants, often experts in various fields, work closely with organizations to analyze their challenges, identify opportunities, and provide strategic recommendations.</p>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in" data-aos-delay="300">
                <div class="icon-box">
                    <div class="icon"><i class="bx bx-tachometer"></i></div>
                    <h4><a href="">Audit Services</a></h4>
                    <p>Audit services are professional services provided by auditors to examine and evaluate an entity's financial statements, internal controls, and overall financial reporting processes. The primary goal of audit services is to provide assurance to stakeholders, such as shareholders, investors, creditors, and regulators,
                        regarding the accuracy and reliability of an organization's financial information.</p>
                </div>
            </div>
{{--        </div>--}}
{{--            <div class="row" style="margin-top: 20px !important;">--}}

                <div class="col-xl-4 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in" data-aos-delay="400">
                    <div class="icon-box">
                        <div class="icon"><i class="bx bx-layer"></i></div>
                        <h4><a href="">Training Services</a></h4>
                        <p>
                            Training services involve the delivery of educational programs,
                            courses, workshops, and resources aimed at developing or enhancing the skills,
                            knowledge, and competencies of individuals or groups.
                            These services are offered by training providers, educational institutions,
                            and organizations to address specific learning needs and professional development goals.</p>
                        Training Courses:
                        <?php
                        $services = \App\Models\TrainingService::where('is_active', true)->get();
                            ?>

                        <ul type="none">
                            @foreach($services as $service)
                                <li><i class="ri-check-double-line"></i> {{$service->title}}</li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            <div class="col-xl-4 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in" data-aos-delay="400">
                <div class="icon-box">
                    <div class="icon"><i class="bx bx-layer"></i></div>
                    <h4><a href="">Accounting Software Installation</a></h4>
                    <p>The installation of accounting software involves a series of
                        steps to ensure that the software is correctly set up and configured on a
                        computer or server.<br>
                    Like :</p>
                    <ul>
                        <li>QuickBooks</li>
                        <li>Sage</li>
                        <li>Tally</li>
                        <li>Wave Financial</li>
                        <li>SAP Business One</li>
                    </ul>
                </div>
            </div>

        </div>

    </div>
</section><!-- End Services Section -->
