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
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="card-title mb-0">Company Documents</h4>
                    <div class="mt-2 mt-sm-0">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addFolderModal">
                            <i class="mdi mdi-folder-plus"></i> New Folder
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 col-md-3 mb-4">
                            <a href="{{route('admin.documents.uncategorized')}}" class="text-decoration-none">
                                <div class="card h-100" style="border:1px solid #eef1f3;">
                                    <div class="card-body text-center">
                                        <i class="mdi mdi-folder-outline" style="font-size:40px;color:#9aa5b1;"></i>
                                        <div class="mt-2" style="color:#1F1F1F;font-weight:600;">Uncategorized</div>
                                        <small class="text-muted">{{ $uncategorizedCount }} file(s)</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @foreach($folders as $folder)
                            <div class="col-6 col-md-3 mb-4">
                                <div class="card h-100" style="border:1px solid #eef1f3;">
                                    <div class="card-body text-center position-relative">
                                        @can('manage-documents')
                                            <div class="dropdown position-absolute" style="top:6px;right:6px;">
                                                <button class="btn btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item js-edit-folder"
                                                       data-url="{{route('admin.documents.folders.update',$folder->slug)}}"
                                                       data-name="{{$folder->name}}"
                                                       data-description="{{$folder->description}}">Rename / Edit</a>
                                                    <a href="{{route('admin.documents.folders.delete',$folder->slug)}}" class="dropdown-item js-delete-folder">Delete</a>
                                                </div>
                                            </div>
                                        @endcan
                                        <a href="{{route('admin.documents.folder',$folder->slug)}}" class="text-decoration-none">
                                            <i class="mdi mdi-folder" style="font-size:40px;color:#f0ad4e;"></i>
                                            <div class="mt-2 text-truncate" style="color:#1F1F1F;font-weight:600;" title="{{$folder->name}}">{{ $folder->name }}</div>
                                            <small class="text-muted">{{ $folder->documents_count }} file(s)</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($folders->isEmpty())
                        <p class="text-muted mb-0">No folders yet. Documents not filed into a folder appear under Uncategorized.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addFolderModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{route('admin.documents.folders.store')}}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Folder</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Folder Name</label>
                            <input type="text" name="name" id="name" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
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

    <div class="modal fade" id="editFolderModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="post" id="editFolderForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Folder</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_name">Folder Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <textarea name="description" id="edit_description" class="form-control"></textarea>
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
            $(document).on('click', '.js-edit-folder', function (e) {
                e.preventDefault();
                $('#editFolderForm').attr('action', $(this).data('url'));
                $('#edit_name').val($(this).data('name'));
                $('#edit_description').val($(this).data('description'));
                $('#editFolderModal').modal('show');
            });

            $(document).on('click', '.js-delete-folder', function (e) {
                e.preventDefault();
                var href = this.href;
                Swal.fire({
                    title: "Are you sure?",
                    text: "Delete this folder? Its documents will be moved to Uncategorized, not deleted.",
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
