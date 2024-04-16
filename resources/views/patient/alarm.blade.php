@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
                <div class="card">
                    <div class="card-header">Create Drug Alarm</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route("patient.dashboard.storeAlarm") }}">
                            @csrf
                            <div class="form-group row">
                                <label for="label" class="col-md-4 col-form-label text-md-right">Label</label>

                                <div class="col-md-6">
                                    <input id="label" type="text" class="form-control" name="label" required>
                                </div>
                            </div>
                            <br>
                            <div class="form-group row">
                                <label for="repeat" class="col-md-4 col-form-label text-md-right">Repeat</label>

                                <div class="col-md-6">
                                    <input id="repeat" type="text" class="form-control" name="repeat" required
                                        autofocus>
                                </div>
                            </div>
                            <br>
                            <div class="form-group row">
                                <label for="sound" class="col-md-4 col-form-label text-md-right">Sound</label>

                                <div class="col-md-6">
                                    <input id="sound" type="text" class="form-control" name="sound" required>
                                </div>
                            </div>
                            <br>
                            <div class="form-group row">
                                <label for="time" class="col-md-4 col-form-label text-md-right">Time</label>

                                <div class="col-md-6">
                                    <input id="time" type="time" class="form-control" name="time" required>
                                </div>
                            </div>
                            <br>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Create Alarm
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
