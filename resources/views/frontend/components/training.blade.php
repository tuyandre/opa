<!-- ======= Contact Section ======= -->
<style>
    #contact .form-section-label {
        color: #146c77;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 10px 0 15px 0;
        padding-bottom: 8px;
        border-bottom: 2px solid #e7f5fb;
    }

    #contact .select2-container {
        width: 100% !important;
    }

    #contact .select2-container .select2-selection--single {
        height: 44px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        display: flex;
        align-items: center;
    }

    #contact .select2-container .select2-selection--multiple {
        min-height: 44px;
        height: auto;
        border: 1px solid #ced4da;
        border-radius: 4px;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    #contact .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 42px;
        padding-left: 12px;
    }

    #contact .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 42px;
    }

    #contact .select2-container--default .select2-selection--multiple .select2-selection__rendered {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        padding: 6px 8px;
    }

    /* Brand-matching tags for multi-select choices (services) */
    #contact .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background: #146c77;
        border: none;
        color: #fff;
        border-radius: 4px;
        padding: 3px 8px;
        margin: 0;
    }

    #contact .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #e7f5fb;
        margin-right: 6px;
        border: none;
    }

    #contact .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #e50031;
        background: transparent;
    }

    /*
     * Select2 appends its open dropdown panel to <body>, not inside #contact,
     * so these rules are intentionally unscoped (training form is the only
     * select2 user on the site today).
     */
    .select2-dropdown {
        border-color: #146c77;
        border-radius: 4px;
        overflow: hidden;
    }

    .select2-container--default .select2-search--dropdown .select2-search__field {
        border-color: #ced4da;
        border-radius: 4px;
    }

    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #e7f5fb;
        color: #146c70;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #146c77;
        color: #fff;
    }

    #contact .password-field {
        position: relative;
    }

    #contact .password-field input {
        padding-right: 44px;
    }

    #contact .password-field .toggle-password {
        position: absolute;
        top: 0;
        right: 0;
        height: 44px;
        width: 44px;
        border: 0;
        background: transparent;
        color: #6c757d;
        cursor: pointer;
    }

    #contact .password-field .toggle-password:hover {
        color: #146c77;
    }

    @media (max-width: 767px) {
        #contact .section-title h2 {
            font-size: 26px;
        }

        #contact .form-section-label {
            font-size: 13px;
        }

        #contact .agreement-box {
            flex-direction: column;
        }
    }

    #contact .agreement-box {
        background: #e7f5fb;
        border-left: 4px solid #146c77;
        border-radius: 4px;
        padding: 15px 18px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    #contact .agreement-box input[type="checkbox"] {
        margin-top: 4px;
        width: 18px;
        height: 18px;
        flex-shrink: 0;
    }

    #contact .agreement-box label {
        margin: 0;
        font-size: 14px;
        color: #146c70;
    }
</style>
<section id="contact" class="contact" style="background: #146c77; padding-top: 80px; padding-bottom: 60px">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2 style="color: white">Training Registration</h2>
            <p style="color: #e7f5fb">Fill in the form below to secure your seat. Your account credentials will let you track your training progress afterwards.</p>
        </div>
        <div class="row">

            <div class="col-lg-12 mt-5 mt-lg-0 d-flex align-items-stretch">
                <form action="{{route('frontend.registration.store')}}" method="post" role="form" id="training_form" class="php-email-form">
                  @csrf
                    <div class="row">

                        <div class="form-group col-12">
                            @if(session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                            @if(session()->has('error'))
                                <div class="alert alert-danger">
                                    {{ session()->get('error') }}
                                </div>
                            @endif
                        </div>

                        <div class="col-12">
                            <div class="form-section-label">Training Details</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="session">Select Session *</label>
                            <select class="form-control select2"   name="session_id" id="session" style="width: 100%" required data-placeholder="Select Session/Training do you wish to Attend">
                                <option value=""></option>
                                @foreach($sessions as $session)
                                    <option value="{{$session->id}}">{{$session->session_title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="service">Select service/Training do you wish to have *</label>
                            <select class="form-control select2" multiple name="services[]" id="service" style="width: 100%" required data-placeholder="Select service/Training do you wish to have">
                                @foreach($services as $service)
                                <option value="{{$service->id}}">{{$service->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <div class="form-section-label">Personal Information</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Your Full Name *</label>
                            <input type="text" name="name" class="form-control" id="name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Your Email *</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="telephone">Your Phone *</label>
                                <input type="text" class="form-control" name="telephone" id="telephone" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="gender">Select Gender *</label>
                            <select class="form-control select2"   name="gender" id="gender" style="width: 100%" required data-placeholder="Select Gender">
                                <option value=""></option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="B-sexual">B-sexual</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="education_level">Select Level of Education *</label>
                            <select class="form-control select2"   name="education_level" id="education_level" style="width: 100%" required data-placeholder="Select Education Level">
                                <option value=""></option>
                                <option value="Secondary Education(A2)">Secondary Education(A2)</option>
                                <option value="Post-Secondary Diplomas(A1)">Post-Secondary Diplomas(A1)</option>
                                <option value="Bachelor">Bachelor</option>
                                <option value="Master">Master</option>
                                <option value="Doctorate(PhD)">Doctorate(PhD)</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="position">Select Position do you hold in your company  *</label>
                            <select class="form-control select2"   name="position" id="position" style="width: 100%" required data-placeholder="Select Position">
                                <option value=""></option>
                                <option value="CEO">CEO</option>
                                <option value="HR">HR</option>
                                <option value="CFO">CFO</option>
                                <option value="Accountant">Accountant</option>
                                <option value="Auditor">Auditor</option>
                                <option value="Cashier">Cashier</option>
                                <option value="Procurement">Procurement</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="form-control" name="company_name" id="company_name" >
                        </div>
                        <div class="form-group col-md-6">
                            <label for="company_tin">Company Tin</label>
                            <input type="number" class="form-control" name="company_tin" id="company_tin" minlength="9" maxlength="9">
                        </div>

                        <div class="col-12">
                            <div class="form-section-label">Account &amp; Security</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Create Password *</label>
                            <div class="password-field">
                                <input type="password" class="form-control" name="password" id="password" minlength="8" required autocomplete="new-password">
                                <button type="button" class="toggle-password" data-target="#password" aria-label="Show password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password_confirmation">Confirm Password *</label>
                            <div class="password-field">
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" minlength="8" required autocomplete="new-password">
                                <button type="button" class="toggle-password" data-target="#password_confirmation" aria-label="Show password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group col-12">
                            <label for="comment">Comment</label>
                            <textarea class="form-control" name="comment" rows="3" id="comment"  required></textarea>
                        </div>

                        <div class="form-group col-12">
                            <div class="agreement-box">
                                <input type="checkbox" value="1" name="agreement" id="agreement">
                                <label for="agreement">I understand that I will have to pay 300,000.00 RWf before enrollment for the training of my choice and
                                    two consecutive absences with no clear justification leads to automatic dismissal from the training program.</label>
                            </div>
                        </div>
                    </div>


                    <div class="text-center">
                        <input type="submit" class="btn btn-info rounded btn-contactus" value="Register"/></div>
                </form>

            </div>

        </div>

    </div>
</section><!-- End Contact Section -->

@push('scripts')
    <script>
        document.querySelectorAll('#contact .toggle-password').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var input = document.querySelector(btn.getAttribute('data-target'));
                var icon = btn.querySelector('i');
                var isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                icon.classList.toggle('bi-eye', !isHidden);
                icon.classList.toggle('bi-eye-slash', isHidden);
            });
        });
    </script>
@endpush
