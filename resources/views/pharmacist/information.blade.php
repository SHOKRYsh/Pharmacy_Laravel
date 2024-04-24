@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Pharmacist Information') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('pharmacist.dashboard.storeInformation') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <div class="text-center mb-3">
                                    <img src="{{ asset($pharmacist->image_url) }}" class="rounded-circle" height="200px" width="200px" alt="Profile Image">
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
