@extends('layouts.app')

@section('content')
    <div class="container">
        <h4 class="text-center">Approval Page</h4>

        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>Pharmacy Name</th>
                    <th>Email</th>
                    <th>Syndicate Id</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pharmacists as $pharmacist)
                    <tr>
                        <td>{{ $pharmacist->user->name }}</td>
                        <td>{{ $pharmacist->user->email }}</td>
                        <td>
                            <img src="{{ asset($pharmacist->syndicate_id) }}" height="100px" width="100px" alt="Syndicate ID Image">
                        </td>
                        <td>
                            <form method="post" action="{{ route('admin.approval.update', ['id' => $pharmacist->id]) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    Accept
                                </button>
                            </form>
                            <br>
                            <form method="post" action="{{ route('admin.approval.destroy', ['id' => $pharmacist->id]) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
