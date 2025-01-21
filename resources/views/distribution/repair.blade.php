@extends('layouts/app')
@section('content')
<section class="app-user-list">
  <!-- list and filter start -->
  <div class="card mt-4">
    <div class="card-datatable table-responsive pt-0">
    <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
    <h1 class="mb-0 ml-3">Repairs</h1>
</div>
        <table id="claim-table" class="display table table-bordered">
        <thead>
            <tr>
            <th>Article No</th>
            <th>Name</th>
            <th>Invoice</th>
            <th>Purchase Date</th>
            <th>Article Price</th>
            <th>Period</th>
            <th>Customer Name</th>
            <th>Customer Address</th>
            <th>Customer Email</th>
            <th>Ptcl</th>
            <th>Cell</th>
            <th>Shop Name</th>
            <th>Status</th>
            <th>Actions</th>
            </tr>
        </thead>
        @if(!$claims->isEmpty())
        <tbody>
                @foreach ($claims as $claim)
                    <tr>
                        <td>{{ $claim->article_number }}</td>
                        <td>{{ $claim->name }}</td>
                        <td>{{ $claim->invoice }}</td>
                        <td>{{ $claim->purchase_date }}</td>
                        <td>{{ $claim->article_price }}</td>
                        <td>{{ $claim->period }}</td>
                        <td>{{ $claim->customer_name }}</td>
                        <td>{{ $claim->customer_address }}</td>
                        <td>{{ $claim->customer_email }}</td>
                        <td>{{ $claim->ptcl }}</td>
                        <td>{{ $claim->cell }}</td>
                        <td>{{ $claim->shops->name }}</td>
                        <td>{{ $claim->status == 3 ? "Reparing" : ""}}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                <li><a href="{{route('distribution.createSubmitRecord',$claim->id)}}" class="dropdown-item">Submit</a></li>
                                <li><a class="dropdown-item" href="{{route('claim.claim.settlement.form',$claim->id)}}">View</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
              </tbody>
              @else
              <tbody>
                <tr>
                  <td colspan="14" class="text-center">
                    No claim available.
                  </td>                
                </tr>
              </tbody>
              @endif
        </table>
    </div>
</div>
<br>
  <br>
  <br>
  <!-- list and filter end -->
</section>
@endsection
