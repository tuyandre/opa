@extends('backend.partials.master')

@section('content')

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Students Lists
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
                                <th>Training Session</th>
                                <th>Full Name</th>
                                <th>Telephone</th>
                                <th>Email</th>
                                <th>Registration Date</th>
                                <th>Company Tin</th>
                                <th>Company Name</th>
                                <th>Payment Agreement</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{$student->session->session_title}}</td>
                                    <td>{{$student->full_name}}</td>
                                    <td>{{$student->telephone}}</td>
                                    <td>{{$student->email}}</td>
                                    <td>{{$student->created_at}}</td>
                                    <td>{{$student->company_tin}}</td>
                                    <td>{{$student->company_name}}</td>
                                    <td>
                                        @if($student->payment_agreement == 1)
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-danger">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($student->is_paid == 1)
                                            <span class="badge badge-success">Paid</span>
                                        @else
                                            <span class="badge badge-danger">Not Paid</span>
                                        @endif
                                    </td>
                                    <td>
{{--                                        <a href="{{route('students.show', $student->id)}}" class="btn btn-primary btn-sm">View</a>--}}
{{--                                        <a href="{{route('students.destroy', $student->id)}}" class="btn btn-danger btn-sm">Delete</a>--}}
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
