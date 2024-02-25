@extends('backend.partials.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Training Materials Lists
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
                            @foreach($materials as $material)
                                <tr>
                                    <td>{{$material->title}}</td>
                                    <td>{{$material->description}}</td>
                                    <td>
                                        <a target="_blank" href="{{route('student.training.materials.download', $material->file)}}" class="btn btn-primary btn-sm">
                                            <i class="mdi mdi-download"></i> Download
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
@section('scripts')
    <script type="text/javascript" src="{{ asset($ROOT_FOLDER.'vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>
    <script type="text/javascript" src="{{ url($ROOT_FOLDER.'vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <script>
        $(document).ready(function () {

            $(document).on('click', '.delete_btn', function (e) {
                e.preventDefault();
                var href = this.href;
                Swal.fire({
                    title: "Are you sure?",
                    text: "Delete this Service ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((willDelete) => {
                    if (willDelete.value) {
                        window.location = href;
                    } else {
                        //swal("Your imaginary file is safe!");
                    }
                });
            });

        });
    </script>



@endsection

