@extends('backend.partials.master')

@section('content')
    <?php
    use App\Constants\VariableConstants;
    use Illuminate\Support\Str;
    $main_url = url()->to('/');
    $ROOT_FOLDER = $main_url.VariableConstants::ROOT_FOLDER;

    $documents = $client->documents->where('type', 'document');
    $contracts = $client->documents->where('type', 'contract');
    ?>

    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="card-title mb-0">{{ $client->name }}</h4>
                    @can('update-clients')
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2 mt-sm-0" data-toggle="modal" data-target="#editModal">
                            <i class="mdi mdi-pencil"></i> Edit
                        </button>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if($client->logo)
                            <img src="{{asset('uploads/clients/logos/'.$client->logo)}}" style="width:72px;height:72px;object-fit:cover;border-radius:50%;">
                        @else
                            <div class="opa-avatar mx-auto" style="width:72px;height:72px;font-size:28px;">{{ strtoupper(substr($client->name,0,1)) }}</div>
                        @endif
                        <p class="mb-0 mt-2">
                            @if($client->status === 'Active')
                                <span class="badge badge-success rounded">Active</span>
                            @else
                                <span class="badge badge-danger rounded">Inactive</span>
                            @endif
                        </p>
                    </div>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-start mb-3">
                            <i class="mdi mdi-pound text-muted mr-2 mt-1" style="width:18px;flex-shrink:0;"></i>
                            <div class="text-break"><div>{{ $client->tax_number ?: '—' }}</div><small class="text-muted">Tax Number</small></div>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="mdi mdi-email-outline text-muted mr-2 mt-1" style="width:18px;flex-shrink:0;"></i>
                            <div class="text-break"><div>{{ $client->email ?: '—' }}</div><small class="text-muted">Email</small></div>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="mdi mdi-phone text-muted mr-2 mt-1" style="width:18px;flex-shrink:0;"></i>
                            <div class="text-break"><div>{{ $client->phone ?: '—' }}</div><small class="text-muted">Phone</small></div>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <i class="mdi mdi-map-marker-outline text-muted mr-2 mt-1" style="width:18px;flex-shrink:0;"></i>
                            <div class="text-break"><div>{{ $client->address ?: '—' }}</div><small class="text-muted">Address</small></div>
                        </li>
                        <li class="d-flex align-items-start {{ $client->notes ? 'mb-3' : '' }}">
                            <i class="mdi mdi-domain text-muted mr-2 mt-1" style="width:18px;flex-shrink:0;"></i>
                            <div class="text-break"><div>{{ $client->business_sector ?: '—' }}</div><small class="text-muted">Business Sector</small></div>
                        </li>
                    </ul>
                    @if($client->notes)
                        <hr>
                        <p class="text-muted mb-0" style="font-size: 13px;">{{ $client->notes }}</p>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="card-title mb-0">Contacts</h4>
                    @can('update-clients')
                        <button type="button" class="btn btn-primary btn-sm mt-2 mt-sm-0" data-toggle="modal" data-target="#addContactModal">
                            <i class="mdi mdi-plus"></i> Add Contact
                        </button>
                    @endcan
                </div>
                <div class="card-body">
                    @forelse($client->contacts as $contact)
                        <div class="d-flex justify-content-between align-items-start {{ !$loop->last ? 'mb-3 pb-3' : '' }}" style="{{ !$loop->last ? 'border-bottom:1px solid #eee;' : '' }}">
                            <div class="text-break">
                                <div><strong>{{ $contact->name }}</strong>{{ $contact->position ? ' — '.$contact->position : '' }}</div>
                                @if($contact->phone)<div class="text-muted" style="font-size:13px;"><i class="mdi mdi-phone"></i> {{ $contact->phone }}</div>@endif
                                @if($contact->email)<div class="text-muted" style="font-size:13px;"><i class="mdi mdi-email-outline"></i> {{ $contact->email }}</div>@endif
                            </div>
                            @can('update-clients')
                                <div class="dropdown">
                                    <button class="btn btn-2x btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item js-edit-contact"
                                           data-url="{{route('admin.clients.contacts.update',$contact->id)}}"
                                           data-name="{{$contact->name}}"
                                           data-phone="{{$contact->phone}}"
                                           data-email="{{$contact->email}}"
                                           data-position="{{$contact->position}}">Edit</a>
                                        <a href="{{route('admin.clients.contacts.delete',$contact->id)}}" class="dropdown-item js-delete-doc">Delete</a>
                                    </div>
                                </div>
                            @endcan
                        </div>
                    @empty
                        <p class="text-muted mb-0">No contacts added yet.</p>
                    @endforelse
                </div>
            </div>

            @can('update-clients')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Follow-up Assignment</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.clients.assign',$client->slug)}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="assigned_to">Assigned To</label>
                            <select name="assigned_to" id="assigned_to" class="form-control">
                                <option value="">Unassigned</option>
                                @foreach($staff as $member)
                                    <option value="{{$member->id}}" {{ $client->assigned_to == $member->id ? 'selected' : '' }}>{{$member->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Update Assignment</button>
                    </form>
                </div>
            </div>
            @endcan
        </div>

        <div class="col-12 col-lg-8">
            @can('view-client-documents')
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="card-title mb-0">Documents</h4>
                    @can('upload-client-documents')
                        <button type="button" class="btn btn-primary btn-sm mt-2 mt-sm-0" data-type="document" data-toggle="modal" data-target="#uploadModal">
                            <i class="mdi mdi-upload"></i> Add Document
                        </button>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Uploaded By</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($documents as $document)
                                <tr>
                                    <td><span class="d-inline-block text-truncate" style="max-width:180px;vertical-align:bottom;" title="{{ $document->title }}">{{ $document->title }}</span></td>
                                    <td><span class="d-inline-block text-truncate" style="max-width:220px;vertical-align:bottom;" title="{{ $document->description }}">{{ $document->description }}</span></td>
                                    <td>{{ $document->uploadedBy->name ?? '—' }}</td>
                                    <td>{{ $document->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <a href="{{route('admin.clients.documents.view',$document->slug)}}" class="badge badge-info rounded" title="View in system"><i class="mdi mdi-eye"></i> View</a>
                                        @can('download-client-documents')
                                            <a href="{{route('admin.clients.documents.download',$document->slug)}}" class="badge badge-success rounded"><i class="mdi mdi-download"></i> Download</a>
                                        @endcan
                                        @can('delete-client-documents')
                                            <a href="{{route('admin.clients.documents.delete',$document->id)}}" class="badge badge-danger rounded js-delete-doc"><i class="mdi mdi-delete"></i> Delete</a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted">No documents uploaded yet.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="card-title mb-0">Contracts</h4>
                    @can('upload-client-documents')
                        <button type="button" class="btn btn-primary btn-sm mt-2 mt-sm-0" data-type="contract" data-toggle="modal" data-target="#uploadModal">
                            <i class="mdi mdi-upload"></i> Add Contract
                        </button>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Uploaded By</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($contracts as $contract)
                                <tr>
                                    <td><span class="d-inline-block text-truncate" style="max-width:180px;vertical-align:bottom;" title="{{ $contract->title }}">{{ $contract->title }}</span></td>
                                    <td><span class="d-inline-block text-truncate" style="max-width:220px;vertical-align:bottom;" title="{{ $contract->description }}">{{ $contract->description }}</span></td>
                                    <td>{{ $contract->uploadedBy->name ?? '—' }}</td>
                                    <td>{{ $contract->created_at->format('M j, Y') }}</td>
                                    <td>
                                        <a href="{{route('admin.clients.documents.view',$contract->slug)}}" class="badge badge-info rounded" title="View in system"><i class="mdi mdi-eye"></i> View</a>
                                        @can('download-client-documents')
                                            <a href="{{route('admin.clients.documents.download',$contract->slug)}}" class="badge badge-success rounded"><i class="mdi mdi-download"></i> Download</a>
                                        @endcan
                                        @can('delete-client-documents')
                                            <a href="{{route('admin.clients.documents.delete',$contract->id)}}" class="badge badge-danger rounded js-delete-doc"><i class="mdi mdi-delete"></i> Delete</a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted">No contracts uploaded yet.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endcan

            @can('view-client-systems')
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="card-title mb-0">System Accounts</h4>
                    @can('create-client-systems')
                        <button type="button" class="btn btn-primary btn-sm mt-2 mt-sm-0" data-toggle="modal" data-target="#addSystemModal">
                            <i class="mdi mdi-plus"></i> Add System Account
                        </button>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>App</th>
                                <th>URL</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Reset Phone</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($client->systemAccounts as $account)
                                <tr>
                                    <td>{{ $account->app_name }}</td>
                                    <td>
                                        @if($account->url)
                                            <a href="{{ Str::startsWith($account->url, ['http://','https://']) ? $account->url : 'http://'.$account->url }}" target="_blank" rel="noopener" title="{{ $account->url }}" class="d-inline-block text-truncate" style="max-width:160px;vertical-align:bottom;">{{ $account->url }}</a>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td><span class="d-inline-block text-truncate" style="max-width:140px;vertical-align:bottom;" title="{{ $account->username }}">{{ $account->username ?: '—' }}</span></td>
                                    <td>
                                        @can('view-client-system-passwords')
                                            {{ $account->password ?: '—' }}
                                        @else
                                            @if($account->password)
                                                &bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;
                                            @else
                                                —
                                            @endif
                                        @endcan
                                    </td>
                                    <td>{{ $account->reset_phone_number ?: '—' }}</td>
                                    <td>
                                        @canany(['update-client-systems','delete-client-systems'])
                                            <div class="dropdown">
                                                <button class="btn btn-2x btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu">
                                                    @can('update-client-systems')
                                                        <a href="#" class="dropdown-item js-edit-system"
                                                           data-url="{{route('admin.clients.systems.update',$account->id)}}"
                                                           data-app_name="{{$account->app_name}}"
                                                           data-url_value="{{$account->url}}"
                                                           data-username="{{$account->username}}"
                                                           data-reset_phone_number="{{$account->reset_phone_number}}">Edit</a>
                                                    @endcan
                                                    @can('delete-client-systems')
                                                        <a href="{{route('admin.clients.systems.delete',$account->id)}}" class="dropdown-item js-delete-doc">Delete</a>
                                                    @endcan
                                                </div>
                                            </div>
                                        @endcanany
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">No system accounts added yet.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endcan
        </div>
    </div>

    @can('update-clients')
    <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{route('admin.clients.update',$client->slug)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Client</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" value="{{$client->name}}" required/>
                        </div>
                        <div class="form-group">
                            <label for="edit_tax_number">Tax Number</label>
                            <input type="text" name="tax_number" id="edit_tax_number" class="form-control" value="{{$client->tax_number}}"/>
                        </div>
                        <div class="form-group">
                            <label for="edit_email">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control" value="{{$client->email}}"/>
                        </div>
                        <div class="form-group">
                            <label for="edit_phone">Phone</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control" value="{{$client->phone}}"/>
                        </div>
                        <div class="form-group">
                            <label for="edit_address">Address</label>
                            <textarea name="address" id="edit_address" class="form-control">{{$client->address}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_business_sector">Business Sector</label>
                            <input type="text" name="business_sector" id="edit_business_sector" class="form-control" value="{{$client->business_sector}}"/>
                        </div>
                        <div class="form-group">
                            <label for="edit_logo">Logo</label>
                            <input type="file" name="logo" id="edit_logo" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">Status</label>
                            <select name="status" id="edit_status" class="form-control" required>
                                <option value="Active" {{ $client->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $client->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_notes">Notes</label>
                            <textarea name="notes" id="edit_notes" class="form-control">{{$client->notes}}</textarea>
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

    @can('upload-client-documents')
    <div class="modal fade" id="uploadModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{route('admin.clients.documents.store',$client->slug)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="uploadModalTitle">Upload File</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="type" id="upload_type" value="document">
                        <div class="form-group">
                            <label for="upload_title">Title</label>
                            <input type="text" name="title" id="upload_title" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label for="upload_description">Description</label>
                            <textarea name="description" id="upload_description" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="upload_file">File</label>
                            <input type="file" name="file" id="upload_file" class="form-control" required/>
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

    @can('create-client-systems')
    <div class="modal fade" id="addSystemModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{route('admin.clients.systems.store',$client->slug)}}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add System Account</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="sys_app_name">App Name</label>
                            <input type="text" name="app_name" id="sys_app_name" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label for="sys_url">URL</label>
                            <input type="text" name="url" id="sys_url" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="sys_username">Username / Email</label>
                            <input type="text" name="username" id="sys_username" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="sys_password">Password</label>
                            <input type="text" name="password" id="sys_password" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="sys_reset_phone_number">Reset Phone Number</label>
                            <input type="text" name="reset_phone_number" id="sys_reset_phone_number" class="form-control"/>
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

    @can('update-client-systems')
    <div class="modal fade" id="editSystemModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="post" id="editSystemForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update System Account</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_sys_app_name">App Name</label>
                            <input type="text" name="app_name" id="edit_sys_app_name" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label for="edit_sys_url">URL</label>
                            <input type="text" name="url" id="edit_sys_url" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="edit_sys_username">Username / Email</label>
                            <input type="text" name="username" id="edit_sys_username" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="edit_sys_password">Password <small class="text-muted">(leave blank to keep unchanged)</small></label>
                            <input type="text" name="password" id="edit_sys_password" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="edit_sys_reset_phone_number">Reset Phone Number</label>
                            <input type="text" name="reset_phone_number" id="edit_sys_reset_phone_number" class="form-control"/>
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

    @can('update-clients')
    <div class="modal fade" id="addContactModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{route('admin.clients.contacts.store',$client->slug)}}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Contact</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="contact_name">Name</label>
                            <input type="text" name="name" id="contact_name" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label for="contact_position">Position</label>
                            <input type="text" name="position" id="contact_position" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="contact_phone">Phone</label>
                            <input type="text" name="phone" id="contact_phone" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="contact_email">Email</label>
                            <input type="email" name="email" id="contact_email" class="form-control"/>
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

    <div class="modal fade" id="editContactModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="post" id="editContactForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Contact</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_contact_name">Name</label>
                            <input type="text" name="name" id="edit_contact_name" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label for="edit_contact_position">Position</label>
                            <input type="text" name="position" id="edit_contact_position" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="edit_contact_phone">Phone</label>
                            <input type="text" name="phone" id="edit_contact_phone" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="edit_contact_email">Email</label>
                            <input type="email" name="email" id="edit_contact_email" class="form-control"/>
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
            $(document).on('click', '[data-target="#uploadModal"]', function () {
                var type = $(this).data('type');
                $('#upload_type').val(type);
                $('#uploadModalTitle').text(type === 'contract' ? 'Upload Contract' : 'Upload Document');
            });

            $(document).on('click', '.js-delete-doc', function (e) {
                e.preventDefault();
                var href = this.href;
                Swal.fire({
                    title: "Are you sure?",
                    text: "Delete this permanently?",
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

            $(document).on('click', '.js-edit-system', function (e) {
                e.preventDefault();
                $('#editSystemForm').attr('action', $(this).data('url'));
                $('#edit_sys_app_name').val($(this).data('app_name'));
                $('#edit_sys_url').val($(this).data('url_value'));
                $('#edit_sys_username').val($(this).data('username'));
                $('#edit_sys_reset_phone_number').val($(this).data('reset_phone_number'));
                $('#edit_sys_password').val('');
                $('#editSystemModal').modal('show');
            });

            $(document).on('click', '.js-edit-contact', function (e) {
                e.preventDefault();
                $('#editContactForm').attr('action', $(this).data('url'));
                $('#edit_contact_name').val($(this).data('name'));
                $('#edit_contact_phone').val($(this).data('phone'));
                $('#edit_contact_email').val($(this).data('email'));
                $('#edit_contact_position').val($(this).data('position'));
                $('#editContactModal').modal('show');
            });
        });
    </script>
@endsection
