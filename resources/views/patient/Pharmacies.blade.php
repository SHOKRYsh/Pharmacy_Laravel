<!-- resources/views/patient/add.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Nearest Pharmacies') }}</div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Pharmacist</th>
                                        <th>Pharmacy Name</th>
                                        <th>Pharmacy Distance</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nearestPharmacies as $pharmacy)
                                        <tr>
                                            <td>{{ $pharmacy['pharmacist'] }}</td>
                                            <td>{{ $pharmacy['name'] }}</td>
                                            <td>{{ $pharmacy['distance'] }} km</td>
                                            {{-- {{ route('chat', $pharmacy['id']) }} --}}
                                            <td><a href="" class="btn btn-primary">Chat</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
