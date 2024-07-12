@extends('admin.layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col text-center">
                <h1 class="display-4">Welcome, {{ Auth::guard('admin')->user()->name }}!</h1>
                <p class="lead">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <canvas id="myChart"></canvas>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-chart-line"></i> Statistics</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Total Users: <strong>{{ $totalUsers }}</strong></li>
                            <li class="list-group-item">Total Pharmacists: <strong>{{ $totalPharmacicts }}</strong></li>
                            <li class="list-group-item">Total Patients: <strong>{{ $totalPatients }}</strong></li>
                            <li class="list-group-item">Total Orders: <strong>{{ $totalOrders }}</strong></li>
                            <li class="list-group-item">Total Donations: <strong>{{ $totalDonations }}</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h5><i class="fas fa-comments"></i> Recent Comments</h5>
            <ul class="list-group list-group-flush">
                @forelse ($comments as $comment)
                    <li class="list-group-item">
                        <strong>{{ $comment->user->name }} ({{ $comment->user->user_type }}):</strong> {{ $comment->comment }}
                    </li>
                @empty
                    <li class="list-group-item">No comments yet.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Total Users', 'Total Pharmacists', 'Total Patients', 'Total Orders', 'Total Donations'],
                    datasets: [{
                        label: 'Counts',
                        data: [{{ $totalUsers }}, {{ $totalPharmacicts }}, {{ $totalPatients }}, {{ $totalOrders }}, {{ $totalDonations }}],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
