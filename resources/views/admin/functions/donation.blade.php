@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h4 class="text-center mt-4 mb-5">Donation Page</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Name</th>
                        <th>Drug Name</th>
                        <th>Quantity</th>
                        <th>Address</th>
                        <th>Expiry Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($donations as $donation)
                        <tr>
                            <td>{{ $donation->patient->user->name }}</td>
                            <td>{{ $donation->drug_name }}</td>
                            <td>{{ $donation->quantity }}</td>
                            <td>{{ $donation->address }}</td>
                            <td>{{ $donation->expiry_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
