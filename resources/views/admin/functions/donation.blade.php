@extends('layouts.app')

@section('content')
    <div class="container">
        <h4 class="text-center">Approval Page</h4>

        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Drug name</th>
                    <th>Quantity</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($donations as $donation)
                    <tr>
                        <td>{{ $name }}</td>
                        <td>{{ $donation->drug_name }}</td>
                        <td>{{ $donation->quantity }}</td>
                        <td>{{ $donation->address }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
