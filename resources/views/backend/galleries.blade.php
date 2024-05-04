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
                    {{ __('Gallery Lists') }}

                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addModal">
                        Create New Gallery
                    </button>
                </div>

                <div class="card-body">

                    <div class="table-responsive pt-3">
                        <table id="opa_tables" class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>File Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($galleries as $gallery)
                                    <tr>
                                        <td>{{ $gallery->title }}</td>
                                        <td>{{ $gallery->image }}</td>
                                        <td>{{Illuminate\Support\Str::limit($gallery->description, $limit = 100, $end = '...') }}</td>
                                        <td>
                                            @if($gallery->is_active )
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
                                                    <a href="#" data-id="{{$gallery->id}}"
                                                       data-url="{{route('admin.gallery.update',$gallery->id)}}"
                                                       data-title="{{$gallery->title}}"
                                                       data-description="{{$gallery->description}}"
                                                       data-active="{{$gallery->is_active}}"
                                                       class="dropdown-item js-edit">Edit</a>
                                                    <a href="{{route('admin.gallery.destroy',$gallery->id)}}"
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
            <form action="{{route('admin.gallery.store')}}" method="post" id="submissionForm" class="submissionForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Gallery</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="email">Poster Image</label>
                            <input type="file" name="image" id="image" accept="image/*" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="phone">Description</label>
                            <textarea type="text" rows="5" name="description" id="description" class="form-control" required> </textarea>
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
                        <h4 class="modal-title">Update Gallery</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">

                        <div class="form-group">
                            <label for="edit_title">Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control" required/>
                        </div>

                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <textarea type="text"  name="description" id="edit_description" class="form-control" required> </textarea>
                        </div>
                        <div class="form-group">
                            <label for="email">Poster Image</label>
                            <input type="file" name="image" id="edit-image" accept="image/*" class="form-control" />
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
                            <button type="submit" class="btn btn-primary">Confirm </button>
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

