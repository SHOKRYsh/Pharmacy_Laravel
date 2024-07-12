@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h4 class="text-center">Pharmacists</h4>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pharmacists as $pharmacist)
                    <tr>
                        <td>{{ $pharmacist->name }}</td>
                        <td>{{ $pharmacist->email }}</td>
                        <td>
                            <form method="post" action="{{ route('admin.remove.user', ['user_id' => $pharmacist->id]) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
