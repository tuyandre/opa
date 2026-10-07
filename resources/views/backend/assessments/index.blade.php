@extends('backend.partials.master')

@section('content')
    <?php
    use App\Constants\VariableConstants;
    $main_url = url()->to('/');
    $ROOT_FOLDER = $main_url . VariableConstants::ROOT_FOLDER;
    ?>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    {{ __('Assessments') }}
                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addModal">
                        Create Assessment
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive pt-3">
                        <table id="opa_tables" class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>Assessment</th>
                                <th>Client</th>
                                <th>Modules</th>
                                <th>Questions</th>
                                <th>Attendants</th>
                                <th>Pass mark</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($assessments as $assessment)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.assessments.show', $assessment->id) }}"><strong>{{ $assessment->title }}</strong></a>
                                        @if($assessment->version)<br><small class="text-muted">Version {{ $assessment->version }}</small>@endif
                                    </td>
                                    <td>{{ optional($assessment->client)->name ?? '—' }}</td>
                                    <td>{{ $assessment->modules_count }}</td>
                                    <td>{{ $assessment->questions_count }}</td>
                                    <td>{{ $assessment->attendants_count }}</td>
                                    <td>{{ $assessment->pass_mark }}%</td>
                                    <td>
                                        @if($assessment->status === 'Active')
                                            <span class="badge badge-success rounded">Active</span>
                                        @elseif($assessment->status === 'Closed')
                                            <span class="badge badge-danger rounded">Closed</span>
                                        @else
                                            <span class="badge badge-warning rounded">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.assessments.show', $assessment->id) }}" class="btn btn-primary btn-sm">Manage</a>
                                        <button type="button" class="btn btn-outline-danger btn-sm js-delete"
                                                data-url="{{ route('admin.assessments.delete', $assessment->id) }}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($assessments->isEmpty())
                        <p class="text-muted mt-3 mb-0">No assessments yet. Create one, then add modules, questions and attendants.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('admin.assessments.store') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Assessment</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        @include('backend.assessments._form', ['assessment' => null])
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <form id="deleteForm" method="post" style="display:none">@csrf</form>
@endsection

@section('scripts')
    <script>
        $(document).on('click', '.js-delete', function () {
            var url = $(this).data('url');
            Swal.fire({
                title: 'Delete this assessment?',
                text: 'Its modules, questions, attendants and results will be deleted too.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                reverseButtons: true
            }).then(function (result) {
                if (result.isConfirmed) {
                    $('#deleteForm').attr('action', url).submit();
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
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
@endpush
