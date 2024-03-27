@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone" class="col-md-4 col-form-label text-md-end">Phone</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ old('phone') }}" required>

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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

                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end">User Type</label>

                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="user_type" id="pharmacist"
                                            value="pharmacist" {{ old('user_type') == 'pharmacist' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pharmacist">
                                            Pharmacist
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="user_type" id="patient"
                                            value="patient" {{ old('user_type') == 'patient' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="patient">
                                            Patient
                                        </label>
                                    </div>

                                    @error('user_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row mb-3" id="syndicateIdField">
                                    <label for="syndicate_id"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Syndicate ID') }}</label>

                                    <div class="col-md-6">
                                        <input id="syndicate_id" type="file"
                                            class="form-control @error('syndicate_id') is-invalid @enderror"
                                            name="syndicate_id" value="{{ old('syndicate_id') }}"
                                            autocomplete="syndicate_id">

                                        @error('syndicate_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3" id="profilePicField">
                                    <label for="profile_pic"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Profile Picture') }}</label>

                                    <div class="col-md-6">
                                        <input id="profile_pic" type="file"
                                            class="form-control @error('profile_pic') is-invalid @enderror"
                                            name="profile_pic" value="{{ old('profile_pic') }}"
                                            autocomplete="profile_pic">

                                        @error('profile_pic')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var userTypeRadios = document.querySelectorAll('input[name="user_type"]');
            var syndicateIdField = document.getElementById('syndicateIdField');
            var profilePicField = document.getElementById('profilePicField');

            function showHideFields() {
                if (document.querySelector('input[name="user_type"]:checked')) {
                    var userType = document.querySelector('input[name="user_type"]:checked').value;

                    if (userType === 'pharmacist') {
                        syndicateIdField.style.display = 'block';
                    } else {
                        syndicateIdField.style.display = 'none';
                    }

                    profilePicField.style.display = 'block';
                }
            }

            userTypeRadios.forEach(function(radio) {
                radio.addEventListener('change', showHideFields);
            });

            // Initial call to set initial state
            showHideFields();
        });
    </script>
@endsection
