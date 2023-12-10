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
                    {{ __('Training Sessions') }}

                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addModal">
                        Create New Training Session
                    </button>
                </div>

                <div class="card-body">

                    <div class="table-responsive pt-3">
                        <table id="opa_tables" class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Session Title</th>
                                    <th>Session Price</th>
                                    <th>Session Duration</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Students</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($training_sessions as $training_session)
                                    <tr>
                                        <td>{{ $training_session->session_title }}</td>
                                        <td>{{ number_format($training_session->price) }}</td>
                                        <td>{{ $training_session->duration }}</td>
                                        <td>{{ $training_session->start_date }}</td>
                                        <td>{{ $training_session->end_date }}</td>
                                        <td>{{ $training_session->start_time }}</td>
                                        <td>{{ $training_session->end_time }}</td>
                                        <td>
                                            <span class="badge badge-primary rounded">{{ $training_session->students->count() }}</span>
                                        </td>
                                        <td>
                                            @if($training_session->status == "Active")
                                                <span class="badge badge-success rounded">Active</span>
                                            @else
                                                <span class="badge badge-danger rounded">{{$training_session->status}}</span>
                                            @endif
                                        </td>
                                        <td>
{{--                                            <a href="{{ route('backend.training_sessions.edit', $training_session->id) }}" class="btn btn-primary">Edit</a>--}}
{{--                                            <a href="{{ route('backend.training_sessions.delete', $training_session->id) }}" class="btn btn-danger">Delete</a>--}}
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

    <div class="modal fade" id="addModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{route('admin.training.session.store')}}" method="post" id="submissionForm" class="submissionForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Training Session</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                        <div class="form-group col-md-6">
                            <label for="title">Session Title</label>
                            <input type="text" name="session_title" id="title" class="form-control" required/>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="price">Price</label>
                            <input type="number"  name="price" id="price" class="form-control" required />
                        </div>
                            <div class="form-group col-md-6">
                                <label for="start_date">Start Date</label>
                                <input type="date"  name="start_date" id="start_date" class="form-control" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="end_date">End Date</label>
                                <input type="date"  name="end_date" id="end_date" class="form-control" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="start_hour">Start Hour</label>
                                <input type="time"  name="start_time" id="start_hour" class="form-control" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="end_hour">End Hour</label>
                                <input type="time"  name="end_time" id="end_hour" class="form-control" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="days">Working Days</label>
                                <input type="text"  name="days" id="days" class="form-control" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="description">Description</label>
                                <textarea type="text"  name="description" id="description" class="form-control" required > </textarea>
                            </div>

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
        // $('#opa_tables').DataTable();
            //validation
            $("#submissionForm").validate({
                rules: {
                    session_title: {
                        required: true,
                        minlength: 5,
                        maxlength: 50,
                    },
                    price: {
                        required: true,
                        number: true,
                    },
                    start_date: {
                        required: true,
                        date: true,
                    },
                    end_date: {
                        required: true,
                        date: true,
                    },
                    start_time: {
                        required: true,
                        time: true,
                    },
                    end_time: {
                        required: true,
                        time: true,
                    },
                    days: {
                        required: true,
                        minlength: 3,
                        maxlength: 100,
                    },
                    description: {
                        required: true,
                        minlength: 3,
                        maxlength: 100,
                    },
                },
                messages: {
                    session_title: {
                        required: "Please enter your session title",
                        minlength: "Your session title must be at least 3 characters long",
                        maxlength: "Your session title must be at least 50 characters long",
                    },
                    price: {
                        required: "Please enter your price",
                        number: "Please enter a valid price",
                    },
                    start_date: {
                        required: "Please enter your start date",
                        date: "Please enter a valid date",
                    },
                    end_date: {
                        required: "Please enter your end date",
                        date: "Please enter a valid date",
                    },
                    start_time: {
                        required: "Please enter your start hour",
                        time: "Please enter a valid time",
                    },
                    end_time: {
                        required: "Please enter your end hour",
                        time: "Please enter a valid time",
                    },
                    days: {
                        required: "Please enter your working days",
                        minlength: "Your working days must be at least 3 characters long",
                        maxlength: "Your working days must be at least 100 characters long",
                    },
                    description: {
                        required: "Please enter your description",
                        minlength: "Your description must be at least 3 characters long",
                        maxlength: "Your description must be at least 100 characters long",
                    },
                },
                submitHandler: function (form) {
                    form.submit();
                },
            });





        });
    </script>



@endsection

