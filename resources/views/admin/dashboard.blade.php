@extends('admin.layouts.app')

@section('content')
    <h4>
        Dashboard Admin {{ Auth::guard('admin')->user()->name }}
    </h4>


@endsection
