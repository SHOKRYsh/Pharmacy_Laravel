@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h4 class="text-center">Pharmacies with Pharmacists</h4>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>Pharmacy Name</th>
                    <th>Pharmacist Name</th>
                    <th>Email</th>
                    <th>pharmacy Longitude</th>
                    <th>pharmacy Latitude</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($pharmacies as $pharmacy)
                    <tr>
                        <td>{{ $pharmacy->pharmacy_name }}</td>
                        <td>{{ $pharmacy->pharmacist->user->name }}</td>
                        <td>{{ $pharmacy->pharmacist->user->email }}</td>
                        <td>{{ $pharmacy->longitude }}</td>
                        <td>{{ $pharmacy->latitude }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
