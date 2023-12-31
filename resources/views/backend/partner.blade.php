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
                        Create New Partner
                    </button>
                </div>

                <div class="card-body">

                    <div class="table-responsive pt-3">
                        <table id="opa_tables" class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Partner Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Website</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($partners as $partner)
                                    <tr>
                                        <td>{{ $partner->name }}</td>
                                        <td>{{ $partner->email }}</td>
                                        <td>{{ $partner->phone }}</td>
                                        <td>{{ $partner->website }}</td>
                                        <td>
                                            @if($partner->is_active )
                                                <span class="badge badge-success rounded">Active</span>
                                            @else
                                                <span class="badge badge-danger rounded">Desactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-2x btn-primary btn-sm dropdown-toggle action-dropdown" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu " aria-labelledby="dropdownMenuButton">
                                                    <a href="#" data-id="{{$partner->id}}"
                                                       data-url="{{route('admin.service.update',$partner->id)}}"
                                                       data-name="{{$partner->name}}"
                                                       data-phone="{{$partner->phone}}"
                                                       data-website="{{$partner->website}}"
                                                       data-email="{{$partner->email}}"
                                                       data-active="{{$partner->is_active}}"
                                                       class="dropdown-item js-edit">Edit</a>
                                                    <a href="{{route('admin.partner.delete',$partner->id)}}"
                                                       class="dropdown-item js-delete">Delete</a>


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
            <form action="{{route('admin.partner.store')}}" method="post" id="submissionForm" class="submissionForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Partner</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="title">Name</label>
                            <input type="text" name="name" id="title" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="text" name="website" id="website" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" name="logo" id="logo" class="form-control" required />
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
                        <h4 class="modal-title">Update Partner</h4>
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
            //delete_btn
            $(document).on('click', '.js-delete', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this Partner!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then(function (result) {
                    if (result.value) {
                        window.location.href = url;
                    } else if (result.dismiss === "cancel") {
                        swal.fire(
                            "Cancelled",
                            "Your Partner is safe :)",
                            "error"
                        )
                    }
                });

            });



            });

    </script>



@endsection

