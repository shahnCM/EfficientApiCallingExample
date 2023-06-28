@extends('layouts.app')

@section('styles')
    <!-- Date Picker -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Company Data') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ url('/') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="symbol" class="col-md-4 col-form-label text-md-end">{{ __('Symbol') }}</label>

                                <div class="col-md-6">
                                    <input id="symbol" type="text" class="form-control @error('symbol') is-invalid @enderror" name="symbol" value="{{ old('symbol') }}" required autocomplete="symbol" autofocus>

                                    @error('symbol')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="start_date" class="col-md-4 col-form-label text-md-end">{{ __('Start Date') }}</label>

                                <div class="col-md-6">
                                    <input id="start_date" type="text" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date') }}" required autocomplete="start_date">

                                    @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="end_date" class="col-md-4 col-form-label text-md-end">{{ __('End Date') }}</label>

                                <div class="col-md-6">
                                    <input id="end_date" type="text" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}" required autocomplete="end_date">

                                    @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save') }}
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

@section('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(document).ready(function () {
            $("#start_date, #end_date").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true
            });
        });
    </script>
@endsection
