@extends('backend.partials.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Certificates Lists
                        {{--                        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addModal">--}}
                        {{--                            Add New--}}
                        {{--                        </button>--}}
                    </h4>

                </div>
                <div class="card-body">

                    <div class="table-responsive pt-3">
                        <table id="opa_tables" class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                                        @foreach($certificates as $certificate)
                                                            <tr>
                                                                <td>{{$certificate->title}}</td>
                                                                <td>{{$certificate->description}}</td>
                                                                <td>
                                                                    <a href="{{route('student.certificates.download', $certificate->file)}}" class="btn btn-primary btn-sm">
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


@endsection
