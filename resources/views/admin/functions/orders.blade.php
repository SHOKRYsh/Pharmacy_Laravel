@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h4 class="text-center">Orders with Items</h4>

        @foreach ($orders as $order)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Items</h5>
                    <ul class="list-group">
                        @foreach ($order->items as $item)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold">Drug:</span> {{ $item->drug->name_en }}<br>
                                        <span class="fw-bold">Quantity:</span> {{ $item->quantity }}<br>
                                        <span class="fw-bold">Price:</span> {{ $item->price }}
                                    </div>
                                    <div>
                                        <!-- Add any icons or additional information as needed -->
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer text-muted">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-bold">Date:</span> {{ $order->created_at->format('M d, Y') }}<br>
                            <span class="fw-bold">Total Price:</span> {{ $order->total_amount }}<br>
                        </div>
                        <div>
                            <span class="fw-bold">Patient:</span> {{ $order->patient->user->name }}<br>
                            <span class="fw-bold">Pharmacy:</span> {{ $order->pharmacy->pharmacy_name }}<br>
                            <span class="fw-bold">Pharmacist:</span> {{ $order->pharmacy->pharmacist->user->name }}<br>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
