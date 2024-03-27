@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Select the pharmacy</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form method="POST">
                                @csrf
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pharmacies as $pharmacy)
                                            <tr class="pharmacy-row" data-id="{{ $pharmacy->id }}">
                                                <td>
                                                    <a
                                                        href="{{ route('pharmacist.dashboard.pharmacy.drugs', ['pharmacyId' => $pharmacy->id]) }}">
                                                        <label
                                                            class="form-check-label">{{ $pharmacy->pharmacy_name }}</label>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

