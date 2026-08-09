@extends('backend.partials.master')

@section('content')
    <?php
    use App\Constants\VariableConstants;
    $main_url = url()->to('/');
    $ROOT_FOLDER =$main_url.VariableConstants::ROOT_FOLDER;
    $isCompleted = $training_session->isCompleted();

    $certificatesIssuedCount = $students->filter(fn($s) => $s->materials->contains('type', 'certificate'))->count();
    $materialsSharedCount = $students->sum(fn($s) => $s->materials->where('type', 'material')->count());
    $pendingRepliesCount = $students->where('reply_status', 0)->count();
    ?>

    <div class="row">
        <div class="col-md-3 mb-4 stretch-card">
            <div class="card" style="background: #146c77">
                <div class="card-body">
                    <p class="mb-2 text-white"><i class="mdi mdi-account-group"></i> Total Students</p>
                    <p class="fs-30 mb-0 text-white">{{ $students->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card">
            <div class="card" style="background: #17808d">
                <div class="card-body">
                    <p class="mb-2 text-white"><i class="mdi mdi-certificate"></i> Certificates Issued</p>
                    <p class="fs-30 mb-0 text-white">{{ $certificatesIssuedCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card">
            <div class="card" style="background: #0c444b">
                <div class="card-body">
                    <p class="mb-2 text-white"><i class="mdi mdi-file-multiple"></i> Materials Shared</p>
                    <p class="fs-30 mb-0 text-white">{{ $materialsSharedCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 stretch-card">
            <div class="card" style="background: #e50031">
                <div class="card-body">
                    <p class="mb-2 text-white"><i class="mdi mdi-email-alert"></i> Pending Replies</p>
                    <p class="fs-30 mb-0 text-white">{{ $pendingRepliesCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h4 class="card-title mb-1">{{$training_session->session_title}}'s Students List
                            @if($isCompleted)
                                <span class="badge badge-info rounded">Completed</span>
                            @else
                                <span class="badge badge-success rounded">{{$training_session->status}}</span>
                            @endif
                        </h4>
                        <p class="text-muted mb-0" style="font-size: 13px;">
                            <i class="mdi mdi-pound"></i> {{ $training_session->code }}
                            &bull; <i class="mdi mdi-calendar-range"></i> {{ \Carbon\Carbon::parse($training_session->start_date)->format('M j, Y') }} - {{ \Carbon\Carbon::parse($training_session->end_date)->format('M j, Y') }}
                            &bull; <i class="mdi mdi-clock-outline"></i> {{ $training_session->duration }}
                        </p>
                    </div>
                    <div>
                        @if($isCompleted)
                            <button type="submit" form="bulkCertificateForm" class="btn btn-outline-success btn-sm generate_bulk_btn">
                                <i class="mdi mdi-certificate"></i> Generate Certificates for Selected
                            </button>
                        @else
                            <a class="btn btn-outline-primary btn-sm complete_session_btn"
                               href="{{route('admin.training.session.change_status', [$training_session->id, 'Completed'])}}">
                                Mark Session Completed
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @unless($isCompleted)
                        <div class="alert alert-warning d-flex align-items-center">
                            <i class="mdi mdi-information-outline mr-2" style="font-size: 20px;"></i>
                            <span>Certificates can only be issued to students once this session is marked <strong>Completed</strong>.
                            Materials can still be uploaded at any time.</span>
                        </div>
                    @endunless

                    <form id="bulkCertificateForm" method="post" action="{{route('admin.certificates.generate-bulk')}}">
                        @csrf
                        <input type="hidden" name="training_session_id" value="{{$training_session->id}}">
                    <div class="table-responsive pt-3">
                        <table id="opa_tables" class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead>
                            <tr>
                                @if($isCompleted)
                                    <th><input type="checkbox" id="selectAllStudents"></th>
                                @endif
                                <th>Full Name</th>
                                <th>Telephone</th>
                                <th>Email</th>
                                <th>Registration Date</th>
                                <th>Status</th>
                                <th>Company Tin</th>
                                <th>Company Name</th>
                                <th>Payment Agreement</th>
                                <th>Payment Status</th>
                                <th>Materials</th>
                                <th>Certificate</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $student)
                                <?php
                                    $materials = $student->materials->where('type', 'material');
                                    $certificate = $student->materials->firstWhere('type', 'certificate');
                                ?>
                                <tr>
                                    @if($isCompleted)
                                        <td>
                                            @unless($certificate)
                                                <input type="checkbox" name="student_ids[]" value="{{$student->id}}" class="student-select-checkbox">
                                            @endunless
                                        </td>
                                    @endif
                                    <td>{{$student->full_name}}</td>
                                    <td>{{$student->telephone}}</td>
                                    <td>{{$student->email}}</td>
                                    <td>{{$student->created_at}}</td>
                                    <td>
                                        @if($student->reply_status == 1)
                                            @if($student->status == 'Accepted')
                                                <span class="badge badge-success">Accepted</span>
                                            @else
                                                <span class="badge badge-danger">Rejected</span>
                                            @endif
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{$student->company_tin}}</td>
                                    <td>{{$student->company_name}}</td>
                                    <td>
                                        @if($student->payment_agreement == 1)
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-danger">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($student->is_paid == 1)
                                            <span class="badge badge-success">Paid</span>
                                        @else
                                            <span class="badge badge-danger">Not Paid</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($materials->count() > 0)
                                            <div class="mb-1">
                                                @foreach($materials as $material)
                                                    <a href="{{route('student.student-materials.view', $material->slug)}}" class="badge badge-primary rounded" title="{{$material->title}}">
                                                        <i class="mdi mdi-eye"></i> {{ \Illuminate\Support\Str::limit($material->title, 12) }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="badge badge-secondary rounded">None</span>
                                        @endif
                                        <button type="button" class="btn btn-outline-primary btn-sm material_btn" data-student="{{$student->id}}">
                                            <i class="mdi mdi-upload"></i> Add
                                        </button>
                                    </td>
                                    <td>
                                        @if($certificate)
                                            <a href="{{route('student.certificates.view', $certificate->slug)}}" class="badge badge-info rounded" title="View in PDF reader">
                                                <i class="mdi mdi-eye"></i> View
                                            </a>
                                            <a href="{{route('student.certificates.download', $certificate->slug)}}" class="badge badge-success rounded" title="Download PDF">
                                                <i class="mdi mdi-download"></i> Download
                                            </a>
                                        @elseif($isCompleted)
                                            <button type="button" class="btn btn-outline-success btn-sm certificate_btn" data-student="{{$student->id}}">
                                                <i class="mdi mdi-certificate"></i> Issue
                                            </button>
                                        @else
                                            <span class="badge badge-secondary rounded">Not Issued</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-2x btn-primary btn-sm dropdown-toggle action-dropdown"  type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu " aria-labelledby="dropdownMenuButton">
                                                @if($student->reply_status == 0)
                                                    <a class="dropdown-item reply_btn" data-student="{{$student->id}}" href="">Reply</a>
                                                @endif
                                                @if($student->is_paid == 0)
                                                    <a class="dropdown-item btn-success  paid_btn"
                                                       href="{{route('admin.student.change_payment_status', $student->id)}}">Paid</a>
                                                        <a class="dropdown-item  delete_btn"
                                                           href="{{route('admin.student.delete', $student->id)}}">Delete</a>
                                                @endif
                                                <a class="dropdown-item  view_btn"
                                                   href="#">View</a>



                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="replyModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{route('admin.student.reply')}}" method="post" id="submissionForm" class="reply_form" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Reply Student</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="form-group">
                                <label for="status">Decision</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">Select Decision</option>
                                    <option value="Accepted">Accepted</option>
                                    <option value="Accepted">Rejected</option>
                                </select>
                                <input type="hidden" name="student_id" id="student_id" >
                            </div>
                            <div class="form-group">
                                <label for="reply_message">Reply Message</label>
                                <textarea type="text"  name="reply_message" id="reply_message" class="form-control" required > </textarea>
                            </div>

                        </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save </button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
    </div>


    <div class="modal fade" id="certificateModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{route('admin.certificates.store')}}" method="post" id="submissionForm" class="reply_form" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Issue Student Certificate</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required/>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea type="text"  name="description" id="description" class="form-control" required> </textarea>
                        </div>
                        <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" name="file" id="file" class="form-control" required/>
                            <input type="hidden" name="student_id" id="cert_student_id" >
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save </button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
    </div>

    <div class="modal fade" id="materialModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{route('admin.student-materials.store')}}" method="post" id="materialForm" class="material_form" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Student Material</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="material_title">Title</label>
                            <input type="text" name="title" id="material_title" class="form-control" required/>
                        </div>

                        <div class="form-group">
                            <label for="material_description">Description</label>
                            <textarea type="text"  name="description" id="material_description" class="form-control" required> </textarea>
                        </div>
                        <div class="form-group">
                            <label for="material_file">File (PDF, image, document or video)</label>
                            <input type="file" name="file" id="material_file" class="form-control" required/>
                            <small class="text-muted">Students can only view this in-browser; it is not downloadable.</small>
                            <input type="hidden" name="student_id" id="material_student_id" >
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save </button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
    </div>


@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset($ROOT_FOLDER.'vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>
    <script type="text/javascript" src="{{ url($ROOT_FOLDER.'vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <script>
        $(document).ready(function () {
            //delete_btn
            $(document).on('click', '.delete_btn', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this student!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
            //paid_btn
            $(document).on('click', '.paid_btn', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                swal.fire({
                    title: "Are you sure?",
                    text: "Once paid, you will not be able to recover this Payment!",
                    icon: "success",
                    showCancelButton: true,
                    confirmButtonColor: "green",
                    confirmButtonText: "Yes, paid it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
//reply_btn
            $(document).on('click', '.reply_btn', function (e) {
                e.preventDefault();
                var student_id = $(this).data('student');
                $('#student_id').val(student_id);
                $('#replyModal').modal('show');
            });


            $(document).on('click', '.certificate_btn', function (e) {
                e.preventDefault();
                var student_id = $(this).data('student');
                $('#cert_student_id').val(student_id);
                $('#certificateModal').modal('show');
            });

            $(document).on('click', '.material_btn', function (e) {
                e.preventDefault();
                var student_id = $(this).data('student');
                $('#material_student_id').val(student_id);
                $('#materialModal').modal('show');
            });

            //select all / bulk certificate generation
            $(document).on('change', '#selectAllStudents', function () {
                $('.student-select-checkbox').prop('checked', $(this).is(':checked'));
            });

            $('#bulkCertificateForm').on('submit', function (e) {
                e.preventDefault();
                var form = this;
                var count = $('.student-select-checkbox:checked').length;
                if (count === 0) {
                    swal.fire({
                        title: "No students selected",
                        text: "Select at least one student to generate certificates for.",
                        icon: "warning"
                    });
                    return;
                }
                swal.fire({
                    title: "Generate " + count + " certificate(s)?",
                    text: "This will create a certificate PDF for each selected student.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Yes, generate!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            $(document).on('click', '.complete_session_btn', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                swal.fire({
                    title: "Mark this session Completed?",
                    text: "Certificates can be issued to its students once completed.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Yes, mark completed!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });


            //validation
            $("#reply_form").validate({
                rules: {
                    reply_message: {
                        required: true,
                        minlength: 5,
                        maxlength: 500,
                    },
                    reply_status: {
                        required: true,
                    },
                },
                messages: {
                    reply_message: {
                        required: "Please enter your reply message",
                        minlength: "Your reply message must be at least 10 characters long",
                        maxlength: "Your reply message must be at least 500 characters long",
                    },
                    reply_status: {
                        required: "Please select your decision",
                    },
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });

        });


        </script>

@endsection

@push('datatables_styles')
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'backend/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'backend/assets/vendors/datatables.net-bs4/buttons.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'backend/assets/vendors/datatables.net-bs4/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset($ROOT_FOLDER.'backend/assets/vendors/datatables.net-bs4/responsive.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset($ROOT_FOLDER.'backend/assets/js/select.dataTables.min.css')}}">
@endpush

@push('datatables_scripts')
    <script src="{{asset($ROOT_FOLDER.'backend/assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
    <script src="{{asset($ROOT_FOLDER.'backend/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="{{asset($ROOT_FOLDER.'backend/assets/vendors/datatables.net-bs4/buttons.dataTables.min.js')}}"></script>
    <script src="{{asset($ROOT_FOLDER.'backend/assets/vendors/datatables.net-bs4/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset($ROOT_FOLDER.'backend/assets/vendors/datatables.net-responsive/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset($ROOT_FOLDER.'backend/assets/vendors/datatables.net-bs4/responsive.dataTables.min.js')}}"></script>
    <script src="{{asset($ROOT_FOLDER.'backend/assets/vendors/datatables.net-bs4/responsive.bootstrap4.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
@endpush
