@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h4 class="text-center mt-4 mb-5">Approval Page</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Pharmacy Name</th>
                        <th>Email</th>
                        <th>Syndicate ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pharmacists as $pharmacist)
                        <tr>
                            <td>{{ $pharmacist->user->name }}</td>
                            <td>{{ $pharmacist->user->email }}</td>
                            <td>
                                <img src="{{ asset($pharmacist->syndicate_id) }}" class="img-fluid" style="max-height: 100px;" alt="Syndicate ID Image">
                            </td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    <form method="post" action="{{ route('admin.approval.update', ['id' => $pharmacist->id]) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success me-2">
                                            <i class="fas fa-check"></i> Accept
                                        </button>
                                    </form>
                                    <form method="post" action="{{ route('admin.approval.destroy', ['id' => $pharmacist->id]) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
