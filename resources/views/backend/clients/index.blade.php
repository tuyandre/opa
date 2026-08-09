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
                    <h4 class="card-title">Clients
                        @can('create-clients')
                            <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addModal">
                                Add New Client
                            </button>
                        @endcan
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive pt-3">
                        <table id="opa_tables" class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Sector</th>
                                <th>Contact</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($client->logo)
                                                <img src="{{asset('uploads/clients/logos/'.$client->logo)}}" class="mr-2" style="width:28px;height:28px;object-fit:cover;border-radius:50%;">
                                            @else
                                                <div class="opa-avatar mr-2">{{ strtoupper(substr($client->name,0,1)) }}</div>
                                            @endif
                                            <a href="{{route('admin.clients.show',$client->slug)}}">{{ $client->name }}</a>
                                        </div>
                                    </td>
                                    <td>{{ $client->business_sector }}</td>
                                    <td>
                                        {{ $client->email }}
                                        @if($client->email && $client->phone) <br> @endif
                                        {{ $client->phone }}
                                    </td>
                                    <td>
                                        @if($client->assignedTo)
                                            <span class="badge badge-primary">{{ $client->assignedTo->name }}</span>
                                        @else
                                            <span class="badge badge-secondary">Unassigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($client->status === 'Active')
                                            <span class="badge badge-success rounded">Active</span>
                                        @else
                                            <span class="badge badge-danger rounded">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-2x btn-primary btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a href="{{route('admin.clients.show',$client->slug)}}" class="dropdown-item">View</a>
                                                @can('delete-clients')
                                                    <a href="{{route('admin.clients.delete',$client->slug)}}" class="dropdown-item js-delete">Delete</a>
                                                @endcan
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

    @can('create-clients')
    <div class="modal fade" id="addModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{route('admin.clients.store')}}" method="post" id="submissionForm" class="submissionForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Client</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label for="tax_number">Tax Number</label>
                            <input type="text" name="tax_number" id="tax_number" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="business_sector">Business Sector</label>
                            <input type="text" name="business_sector" id="business_sector" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" name="logo" id="logo" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="assigned_to">Assign To</label>
                            <select name="assigned_to" id="assigned_to" class="form-control">
                                <option value="">Unassigned</option>
                                @foreach($staff as $member)
                                    <option value="{{$member->id}}">{{$member->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea name="notes" id="notes" class="form-control"></textarea>
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
    @endcan
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.js-delete', function (e) {
                e.preventDefault();
                var href = this.href;
                Swal.fire({
                    title: "Are you sure?",
                    text: "Delete this client and all their documents/contracts?",
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
