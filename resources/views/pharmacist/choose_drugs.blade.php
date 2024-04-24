@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

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
                                                    <input type="radio" name="selected_pharmacy"
                                                        value="{{ $pharmacy->id }}" class="form-check-input"
                                                        {{ $loop->first ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $pharmacy->pharmacy_name }}</label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Add Drugs to your pharmacy</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="searchInput" placeholder="Search...">
                        </div>
                        <div class="text-center mt-3">
                            <form id="drugForm" action="{{ route('pharmacist.dashboard.storeDrugs') }}" method="POST">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name (English)</th>
                                                <th>Name (Arabic)</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($drugs as $item)
                                                <tr>
                                                    <td>{{ $item->name_en }}</td>
                                                    <td>{{ $item->name_ar }}</td>
                                                    <td>{{ $item->price }}</td>
                                                    <td>
                                                        <input type="number" class="form-control quantityInput"
                                                            drugId="{{ $item->id }}" min="0" value="0">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $drugs->links('pagination::bootstrap-5') }}
                                </div>
                                <input type="hidden" name="selected_drugs" id="selectedDrugs">
                                <button type="submit" class="btn btn-success">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.pharmacy-row').click(function() {
                $('.pharmacy-row').removeClass('selected');
                $(this).addClass('selected');
                $(this).find('input[type="radio"]').prop('checked', true);
            });
        });


        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('.quantityInput').on('change', function() {
                var drugId = $(this).attr('drugId');
                var quantity = $(this).val();
            });
        });


        document.getElementById('drugForm').addEventListener('submit', function(e) {
            e.preventDefault();

            var selectedPharmacyId = $('input[name="selected_pharmacy"]:checked').val();

            var selectedDrugs = [];
            var quantityInputs = document.querySelectorAll('.quantityInput');
            quantityInputs.forEach(function(input) {
                if (parseInt(input.value) > 0) {
                    var drugId = input.getAttribute('drugId');
                    var quantity = input.value;
                    selectedDrugs.push({
                        pharmacyId: selectedPharmacyId,
                        drugId: drugId,
                        quantity: quantity
                    });
                }
            });
            document.getElementById('selectedDrugs').value = JSON.stringify(selectedDrugs);
            this.submit();
        });
    </script>
@endsection

@section('styles')
    <style>
        .table-hover tbody tr:hover {
            cursor: pointer;
            background-color: #f5f5f5;
        }

        .selected {
            background-color: #cce5ff !important;
        }
    </style>
@endsection
