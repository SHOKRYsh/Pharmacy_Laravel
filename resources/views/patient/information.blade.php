<!-- resources/views/patient/add.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Add Patient Information') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('patient.dashboard.storeInformation') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <div class="text-center mb-3">
                                    <img src="{{ asset($patient->image_url) }}" class="rounded-circle" height="200px" width="200px" alt="Profile Image">
                                </div>
                                <br>
                                <label for="profile_pic">Profile Image</label>
                                <input id="profile_pic" type="file" class="form-control" name="profile_pic"
                                    accept="image/*">

                            </div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" type="text" class="form-control " name="name" value="{{ $user->name }}">

                            </div>

                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input id="phone" type="text" class="form-control " value="{{ $user->phone }}" name="phone">

                            </div>


                            <div class="form-group">
                                <label for="address">Address</label>
                                <input id="address" type="text" class="form-control " name="address" value="{{ $patient->address }}">

                            </div>

                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input id="longitude" type="text" class="form-control " name="longitude" value="{{ $patient->longitude }}">

                            </div>

                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input id="latitude" type="text" class="form-control " name="latitude" value="{{ $patient->latitude }}">

                            </div>
                            <br>
                            <button  type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
