@extends('backend.partials.master')

@section('content')



    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Contact Us Lists</h4>
                    <div class="table-responsive pt-3">
                        <table id="opa_tables" class="table table-bordered table-striped table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Telephone</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Submitted At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contact_us as $contact)
                                <tr>
                                    <td>{{$contact->full_name}}</td>
                                    <td>{{$contact->telephone}}</td>
                                    <td>{{$contact->email}}</td>
                                    <td>{{$contact->subject}}</td>
                                    <td>{{$contact->created_at}}</td>
                                    <td>
{{--                                        <a href="{{route('contact_us.show', $contact->id)}}" class="btn btn-primary btn-sm">View</a>--}}
{{--                                        <a href="{{route('contact_us.destroy', $contact->id)}}" class="btn btn-danger btn-sm">Delete</a>--}}
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
