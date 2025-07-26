@extends('backend.partials.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Update Training Session</div>
                    <div class="card-body">
                        <form action="{{route('admin.training.session.update')}}" method="post" id="submissionForm" class="submissionForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="title">Session Title</label>
                                    <input type="text" name="session_title" value="{{$training_session->session_title}}" id="title" class="form-control" required/>
                                    <input type="hidden" name="id" value="{{$training_session->id}}">
                                </div>



                                <div class="form-group col-md-6">
                                    <label for="price">Price</label>
                                    <input type="number"  value="{{$training_session->price}}" name="price" id="price" class="form-control" required />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="start_date">Start Date</label>
                                    <input type="date"  name="start_date" value="{{$training_session->start_date}}" id="start_date" class="form-control" required />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="end_date">End Date</label>
                                    <input type="date"  name="end_date" id="end_date" value="{{$training_session->end_date}}" class="form-control" required />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="start_hour">Start Hour</label>
                                    <input type="time"  name="start_time" id="start_hour" value="{{$training_session->start_time}}" class="form-control" required />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="end_hour">End Hour</label>
                                    <input type="time"  name="end_time" id="end_hour" value="{{$training_session->end_hour}}" class="form-control" required />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="days">Required Student</label>
                                    <input type="number"  name="maximum_students" id="maximum_students"  class="form-control" value="{{$training_session->maximum_students}}" required />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="days">Working Days</label>
                                    <input type="text"  name="days" id="days" value="{{$training_session->days}}" class="form-control" required />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="description">Description</label>
                                    <textarea type="text"  name="description" id="description"  class="form-control" required >
                                    {{$training_session->description}}
                                    </textarea>
                                </div>

                                <div class="btn-group">

                                    <button type="submit" class="btn btn-primary">Update </button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
