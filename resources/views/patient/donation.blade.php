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
                        <h4 class="mb-0">Donation</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route("patient.dashboard.storeDonation") }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="drug_name">Drug Name</label>
                                <input type="text" class="form-control" id="drug_name" name="drug_name" required>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="quantity" min="1" name="quantity" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>

                            <br>
                            <button type="submit" class="btn btn-success">Donate</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
