<!-- resources/views/reports/custom-report-view.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- <div class="row justify-content-center"> -->
    <div class="row mb-12 mt-4 report-container mb-4">
        <!-- <div class="card"> -->
        <div class="col-md-8">
            <h3>Claims Report: {{ $startDate->format('M d, Y') }} to {{ $endDate->format('M d, Y') }}</h3>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('report.custom-report.form') }}" class="btn btn-dark">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <a href="{{ route('report.custom-report.export') }}" class="btn btn-success"
                onclick="event.preventDefault(); document.getElementById('export-form').submit();">
                Export to Excel
            </a>
            <form id="export-form" action="{{ route('report.custom-report.export') }}" method="POST"
                style="display: none;">
                @csrf
                <input type="hidden" name="start_date" value="{{ $startDate->format('Y-m-d') }}">
                <input type="hidden" name="end_date" value="{{ $endDate->format('Y-m-d') }}">
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-12 mt-4">
            <!-- Total Claims -->
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Claims</h5>
                        <h2 class="card-text">{{ $totalClaims }}</h2>
                    </div>
                </div>
            </div>
            <!-- Pending Claims -->
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Pending</h5>
                        <h2 class="card-text">{{ $pendingClaims }}</h2>
                    </div>
                </div>
            </div>
            <!-- Submitted Claims -->
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Submitted</h5>
                        <h2 class="card-text">{{ $submittedClaims }}</h2>
                    </div>
                </div>
            </div>
            <!-- Rejected Claims -->
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Rejected</h5>
                        <h2 class="card-text">{{ $rejectedClaims }}</h2>
                    </div>
                </div>
            </div>
            <!-- Replacing Claims -->
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Replacing</h5>
                        <h2 class="card-text">{{ $replacingClaims }}</h2>
                    </div>
                </div>
            </div>
            <!-- Reparing Claims -->
            <div class="col-md-3">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Reparing</h5>
                        <h2 class="card-text">{{ $reparingClaims }}</h2>
                    </div>
                </div>
            </div>
            <!-- Received Claims -->
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Received</h5>
                        <h2 class="card-text">{{ $receivedClaims }}</h2>
                    </div>
                </div>
            </div>
            <!-- Locally Closed Claims -->
            <div class="col-md-3">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <h5 class="card-title">Locally Closed</h5>
                        <h2 class="card-text">{{ $locallyClosedClaims }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Claim#</th>
                        <th>Articles#</th>
                        <th>Invoice#</th>
                        <th>Shop Manager</th>
                        <th>Shop Name</th>
                        <th>Claim Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($claims as $claim)
                    <tr>
                        <td>{{ $claim->id }}</td>
                        <td>{{ $claim->article_number }}</td>
                        <td>{{ $claim->invoice }}</td>
                        <td>{{ $claim->shop_manager ?? 'N/A' }}</td>
                        <td>{{ $claim->shops->name ?? 'N/A' }}</td>
                        <td>{{ $claim->created_at->format('M d, Y') }}</td>
                        <td>
                            {!! status_label($claim->status) !!}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No claims found for the selected date range</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<br><br>
@endsection