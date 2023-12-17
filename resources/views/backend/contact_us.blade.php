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
                                        <div class="dropdown">
                                            <button class="btn btn-2x btn-primary btn-sm dropdown-toggle action-dropdown" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu rounded" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item delete_btn"  href="{{route('admin.contact.us.delete', $contact->id)}}">
                                                        <span class="badge badge-danger">Delete</span>
                                                    </a>

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


@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            //delete_btn
            $(document).on('click', '.delete_btn', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this Contact Us!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });


        });




    </script>
@endsection
