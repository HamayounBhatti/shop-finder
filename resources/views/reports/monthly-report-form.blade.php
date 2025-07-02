<!-- resources/views/claims/monthly-report-form.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fuild">
    <div class="row justify-content-center mt-7">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header  text-grey">
                    <h4 class="mb-0">Monthly Claims Report</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('report.monthly-report.generate') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="month" class="col-md-4 col-form-label text-md-right">
                                Select Month
                            </label>

                            <div class="col-md-6">
                                <input id="month" type="month" 
                                       class="form-control @error('month') is-invalid @enderror" 
                                       name="month" value="{{ $currentMonth }}" 
                                       required>

                                @error('month')
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
                                
                                @if($months->isNotEmpty())
                                <div class="mt-3">
                                    <p class="mb-1">Available months with data:</p>
                                    <div class="d-flex flex-wrap">
                                        @foreach($months as $month)
                                            <a href="{{ route('report.monthly-report.get', ['month' => $month]) }}" 
                                            class="btn btn-secondary mr-2 mb-2 text-white">
                                                {{ \Carbon\Carbon::parse($month)->format('M Y') }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection