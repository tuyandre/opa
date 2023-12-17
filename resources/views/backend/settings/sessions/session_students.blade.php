@extends('backend.partials.master')

@section('content')
    <?php
    use App\Constants\VariableConstants;
    $main_url = url()->to('/').'/';
    $ROOT_FOLDER =$main_url.VariableConstants::ROOT_FOLDER;
    ?>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$training_session->session_title}} 's Students Lists
                        {{--                        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addModal">--}}
                        {{--                            Add New--}}
                        {{--                        </button>--}}
                    </h4>

                </div>
                <div class="card-body">

                    <div class="table-responsive pt-3">
                        <table id="opa_tables" class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Telephone</th>
                                <th>Email</th>
                                <th>Registration Date</th>
                                <th>Status</th>
                                <th>Company Tin</th>
                                <th>Company Name</th>
                                <th>Payment Agreement</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $student)
                                <tr>
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
