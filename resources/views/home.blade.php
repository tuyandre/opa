@extends('backend.partials.master')

@section('content')


    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        Welcome {{auth()->user()->name}}
                        <h6 class="font-weight-normal mb-0 ">All systems are running smoothly</h6>
                    </h4>

                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-md-12 grid-margin ">
                            <div class="row">
                                <div class="col-md-3 mb-4 stretch-card second">
                                    <div class="card card-tale">
                                        <div class="card-body">
                                            <p class="mb-4">Training Session</p>
                                            <?php

                                            $training_session = \App\Models\TrainingSession::all();
                                            ?>
                                            <p class="fs-30 mb-2">{{$training_session->count()}}</p>
                                            {{--                            <p>10.00% (30 days)</p>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-4 stretch-card transparent">
                                    <div class="card card-dark-blue">
                                        <div class="card-body">
                                            <p class="mb-4">Services</p>
                                            <?php
                                            $services = \App\Models\TrainingService::all();
                                            ?>
                                            <p class="fs-30 mb-2">{{$services->count()}}</p>
                                            {{--                            <p>22.00% (30 days)</p>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-4  stretch-card transparent">
                                    <div class="card card-light-blue">
                                        <div class="card-body">
                                            <p class="mb-4">Students Registered</p>
                                            <?php
                                            $students = \App\Models\RegistrationStudent::all();
                                            ?>
                                            <p class="fs-30 mb-2">{{$students->count()}}</p>
                                            {{--                            <p>2.00% (30 days)</p>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-4 stretch-card transparent">
                                    <div class="card card-light-danger">
                                        <div class="card-body">
                                            <p class="mb-4">Contact Us</p>
                                            <?php
                                            $contact_us = \App\Models\ContactUs::all();
                                            ?>
                                            <p class="fs-30 mb-2">{{$contact_us->count()}}</p>
                                            {{--                            <p>0.22% (30 days)</p>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
