@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Admin Register</div>

                    <div class="card-body">

                        @if (session("errorResponse"))
                            <div class="alert alert-danger">
                                <strong>{{ session("errorResponse") }}</strong>
                            </div>
                        @endif


                        <form method="POST" action="{{ route('admin.register.store') }}" >
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>


                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone" class="col-md-4 col-form-label text-md-end">Phone</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text"
                                        class="form-control" name="phone"
                                        value="{{ old('phone') }}" required>

                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="admin_key"
                                    class="col-md-4 col-form-label text-md-end">Admin Key</label>

                                <div class="col-md-6">
                                    <input id="admin_key" type="password"
                                        class="form-control" name="admin_key"
                                        value="{{ old('admin_key') }}" required >
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control" name="password"
                                        required autocomplete="new-password">

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>


                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
