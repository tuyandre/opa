@extends('backend.partials.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">My Certificates</h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive pt-3">
                        <table id="opa_tables" class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>Session</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($certificates as $certificate)
                                <tr>
                                    <td>{{ $certificate->session->session_title ?? '-' }}</td>
                                    <td>{{$certificate->title}}</td>
                                    <td>{{$certificate->description}}</td>
                                    <td>
                                        <a href="{{route('student.certificates.view', $certificate->slug)}}" class="btn btn-info btn-sm">
                                            <i class="mdi mdi-eye"></i>
                                            View
                                        </a>
                                        <a href="{{route('student.certificates.download', $certificate->slug)}}" class="btn btn-primary btn-sm">
                                            <i class="mdi mdi-download"></i>
                                            Download
                                        </a>
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

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">My Session Materials</h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive pt-3">
                        <table class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>Session</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($materials as $material)
                                <tr>
                                    <td>{{ $material->session->session_title ?? '-' }}</td>
                                    <td>{{$material->title}}</td>
                                    <td>{{$material->description}}</td>
                                    <td>
                                        <a href="{{route('student.student-materials.view', $material->slug)}}" class="btn btn-primary btn-sm">
                                            <i class="mdi mdi-eye"></i>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No materials shared yet.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>


                </div>

            </div>
        </div>
    </div>


@endsection

@push('datatables_styles')
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/datatables.net-bs4/buttons.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/datatables.net-bs4/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/vendors/datatables.net-bs4/responsive.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/js/select.dataTables.min.css')}}">
@endpush

@push('datatables_scripts')
    <script src="{{asset('backend/assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
    <script src="{{asset('backend/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="{{asset('backend/assets/vendors/datatables.net-bs4/buttons.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/assets/vendors/datatables.net-bs4/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('backend/assets/vendors/datatables.net-responsive/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('backend/assets/vendors/datatables.net-bs4/responsive.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/assets/vendors/datatables.net-bs4/responsive.bootstrap4.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
@endpush
