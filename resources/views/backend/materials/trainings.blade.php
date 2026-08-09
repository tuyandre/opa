@extends('backend.partials.master')

@section('content')
    <?php
    use App\Constants\VariableConstants;
    $main_url = url()->to('/');
    $ROOT_FOLDER =$main_url.VariableConstants::ROOT_FOLDER;
    ?>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Training Materials Lists
                                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addModal">
                                                    Add New
                                                </button>
                    </h4>

                </div>
                <div class="card-body">

                    <div class="table-responsive pt-3">
                        <table id="opa_tables" class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Session</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($materials as $material)
                                <tr>
                                    <td>{{$material->title}}</td>
                                    <td>
                                        @if($material->session)
                                            <span class="badge badge-primary rounded">{{$material->session->session_title}}</span>
                                        @else
                                            <span class="badge badge-secondary rounded">All Sessions</span>
                                        @endif
                                    </td>
                                    <td>{{$material->description}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-2x btn-primary btn-sm dropdown-toggle action-dropdown" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu rounded" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item delete_btn" href="{{route('admin.training.materials.delete', $material->id)}}">Delete</a>
                                                <a class="dropdown-item" href="{{route('student.training.materials.view', $material->slug)}}">View</a>

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

    <div class="modal fade" id="addModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{route('admin.training.materials.store')}}" method="post" id="submissionForm" class="submissionForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Training Material</h4>
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
                            <label for="training_session_id">Training Session</label>
                            <select name="training_session_id" id="training_session_id" class="form-control">
                                <option value="">All Sessions (general material)</option>
                                @foreach($sessions as $session)
                                    <option value="{{$session->id}}">{{$session->session_title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="file">File (PDF, image, document or video)</label>
                            <input type="file" name="file" id="file" class="form-control" required/>
                            <small class="text-muted">Students can only view/watch this in-browser; it is not downloadable.</small>
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


    <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="post" id="submissionFormEdit" class="updateForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Service</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">

                        <div class="form-group">
                            <label for="edit_title">Name</label>
                            <input type="text" name="title" id="edit_title" class="form-control" required/>
                        </div>

                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <textarea type="text"  name="description" id="edit_description" class="form-control" required> </textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_is_active">Active</label>
                            <select type="text" name="is_active" id="edit_is_active" class="form-control" required>
                                <option value="">Please Select</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
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
            $("#submissionForm").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 3,
                        maxlength: 50,
                    },
                    description: {
                        required: true,
                        minlength: 3,
                        maxlength: 500,
                    },
                    file: {
                        required: true,
                    },
                },
                messages: {
                    title: {
                        required: "Please enter your title",
                        minlength: "Your title must be at least 3 characters long",
                        maxlength: "Your title must be at least 50 characters long",
                    },
                    description: {
                        required: "Please enter your description",
                        minlength: "Your description must be at least 3 characters long",
                        maxlength: "Your description must be at least 500 characters long",
                    },
                    file: {
                        required: "Please select a file",
                    },
                },
                submitHandler: function (form) {
                    form.submit();
                },
            });

            $(document).on('click', '.delete_btn', function (e) {
                e.preventDefault();
                var href = this.href;
                Swal.fire({
                    title: "Are you sure?",
                    text: "Delete this Service ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((willDelete) => {
                    if (willDelete.value) {
                        window.location = href;
                    } else {
                        //swal("Your imaginary file is safe!");
                    }
                });
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
