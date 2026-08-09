@extends('backend.partials.master')

@section('content')
    <?php
    use App\Constants\VariableConstants;
    $main_url = url()->to('/');
    $ROOT_FOLDER = $main_url.VariableConstants::ROOT_FOLDER;
    ?>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Roles & Permissions
                        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addModal">
                            Add New Role
                        </button>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive pt-3">
                        <table id="opa_tables" class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>Role</th>
                                <th>Permissions</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td><span class="badge badge-primary">{{ $role->permissions_count }} permission(s)</span></td>
                                    <td>
                                        @if($role->name !== 'Student')
                                            <div class="dropdown">
                                                <button class="btn btn-2x btn-primary btn-sm dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a href="#" data-id="{{$role->id}}"
                                                       data-url="{{route('admin.roles.update',$role->id)}}"
                                                       data-name="{{$role->name}}"
                                                       data-permissions="{{ $role->permissions->pluck('name')->implode(',') }}"
                                                       class="dropdown-item js-edit">Edit</a>
                                                    <a href="{{route('admin.roles.delete',$role->id)}}"
                                                       class="dropdown-item js-delete">Delete</a>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">System role</span>
                                        @endif
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
            <form action="{{route('admin.roles.store')}}" method="post" id="submissionForm" class="submissionForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Role</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Role Name</label>
                            <input type="text" name="name" id="name" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label>Permissions</label>
                            <div class="row">
                                @foreach($permissions as $permission)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="permissions[]" value="{{$permission->name}}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="post" id="submissionFormEdit" class="updateForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Role</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_name">Role Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label>Permissions</label>
                            <div class="row">
                                @foreach($permissions as $permission)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input edit-permission-checkbox" name="permissions[]" value="{{$permission->name}}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.js-edit', function (e) {
                e.preventDefault();
                $("#editModal").modal('show');
                $("#edit_name").val($(this).data('name'));
                $("#submissionFormEdit").attr('action', $(this).data('url'));

                var assigned = ($(this).data('permissions') || '').toString().split(',');
                $('.edit-permission-checkbox').each(function () {
                    $(this).prop('checked', assigned.indexOf($(this).val()) !== -1);
                });
            });

            $(document).on('click', '.js-delete', function (e) {
                e.preventDefault();
                var href = this.href;
                Swal.fire({
                    title: "Are you sure?",
                    text: "Delete this role?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((willDelete) => {
                    if (willDelete.value) {
                        window.location = href;
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
