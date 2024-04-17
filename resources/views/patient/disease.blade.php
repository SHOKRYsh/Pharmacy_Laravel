@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Select Chronic Diseases') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form action="{{ route('patient.dashboard.storeDisease') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="chronic_diseases">{{ __('Choose from the following chronic diseases:') }}</label>
                            <select class="form-control" name="chronic_diseases[]" id="chronic_diseases" multiple>
                                @foreach($diseases as $disease)
                                <option value="{{ $disease->id }}">{{ $disease->name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
