@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Create Pharmacy</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route("pharmacist.dashboard.storePharmacy") }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="pharmacy_name">Pharmacy Name</label>
                                <input type="text" class="form-control" id="pharmacy_name" name="pharmacy_name" required>
                            </div>
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" required>
                            </div>
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" required>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-success">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
