@extends('layouts/app')
@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css') }}">
@endsection
@section('content')
<section class="app-user-list">
  <!-- list and filter start -->
  <div class="card mt-4">
    <div class="card-datatable table-responsive pt-0">
    <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
    <h1 class="mb-0 ml-3">Shop Closed Claims</h1>
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
                        <td>{{ $claim->ptcl_number }}</td>
                        <td>{{ $claim->cell }}</td>
                        <td>{{ $claim->shops->name }}</td>
                        <td>{{ $claim->status == 2 ? "Rejected" : "Closed"   }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
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
  <!-- list and filter end -->
</section>
@endsection

@section('vendor-script')
    <script src="{{ asset('vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/responsive.bootstrap5.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/jszip.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
    <script src="{{ asset('vendors/js/tables/datatable/dataTables.rowGroup.min.js') }}"></script>
    <script src="{{ asset('vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
@endsection
@section('page-script')
  {{-- Page js files --}}
  <script>
    $(document).ready(function () {
      $('#claims-table').DataTable(); // Initialize DataTable
    });
  </script>
  <script src="{{ asset('js/scripts/claim/closed-claim-listing.js') }}"></script>
  <script src="{{ asset('js/scripts/claim/claim-record-modal.js') }}"></script>
@endsection
