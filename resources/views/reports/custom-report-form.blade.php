<!-- resources/views/reports/custom-report-form.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fuild">
    <div class="row justify-content-center mt-7">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header  text-grey">
                    <h4 class="mb-0">Customized Report</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('report.custom-report.generate') }}">
                        @csrf

                        <div class="form-group row mb-4">
                            <label for="start_date" class="col-md-4 col-form-label text-md-right">
                                Start Date
                            </label>

                            <div class="col-md-6">
                                <input id="start_date" type="date" 
                                       class="form-control @error('start_date') is-invalid @enderror" 
                                       name="start_date" value="{{ $startDate }}" 
                                       required>

                                @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_date" class="col-md-4 col-form-label text-md-right">
                                End Date
                            </label>

                            <div class="col-md-6">
                                <input id="end_date" type="date" 
                                       class="form-control @error('end_date') is-invalid @enderror" 
                                       name="end_date" value="{{ $endDate }}" 
                                       required>

                                @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0 mt-4">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    Generate Report
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