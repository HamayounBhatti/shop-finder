@extends('layouts/app')
@section('content')
<section class="app-user-list">
  <!-- list and filter start -->
  <div class="card mt-4">
    <div class="card-datatable table-responsive pt-0">
    <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
    <h1 class="mb-0 ml-3">Repairs</h1>
	<div class="d-flex mr-2" style="gap: 10px; margin-left: auto;">
      <small class="search-by-id text-danger"></small>
        <input type="number" id="search-id" class="form-control" placeholder="Search by ID">
        <button class="btn btn-secondary" id="search-btn">Search</button>
    </div>
</div>
        <table id="claim-table" class="display table table-bordered">
        <thead>
            <tr>
			<th>Claim ID</th>
            <th>Article No</th>
            <th>Article Name</th>
			<th>Shop Manager Name</th>
            <th>Invoice</th>
			<th>Claim Date</th>
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
			<th>Closed</th>
            <th>Actions</th>
            </tr>
        </thead>
        @if(!$claims->isEmpty())
        <tbody>
                @foreach ($claims as $claim)
                    <tr>
						<td>{{ $claim->id }}</td>
                        <td>{{ $claim->article_number }}</td>
                        <td>{{ $claim->name }}</td>
						<td>{{ $claim->shop_manager == Null ? 'N/A' : $claim->shop_manager }}</td>
                        <td>{{ $claim->invoice }}</td>
						<td>{{ $claim->created_at->format('Y-m-d') }}</td>
                        <td>{{ $claim->purchase_date }}</td>
                        <td>{{ $claim->article_price }}</td>
                        <td>{{ $claim->period }}</td>
                        <td>{{ $claim->customer_name }}</td>
                        <td>{{ $claim->customer_address }}</td>
                        <td>{{ $claim->customer_email }}</td>
                        <td>{{ $claim->ptcl_number }}</td>
                        <td>{{ $claim->cell }}</td>
                        <td>{{ $claim->shops->name }}</td>
						<td>
								{!! status_label($claim->status) !!}
						</td>
						<td>{{$claim->is_closed == 0 ? 'No' : 'Yes'}}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                <li><a href="{{route('distribution.createSubmitRecord',$claim->id)}}" class="dropdown-item">Submit</a></li>
                                <li><a class="dropdown-item" href="{{route('claim.claim.settlement.form',$claim->id)}}">Report</a></li>
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
		    {{ $claims->links() }}
    </div>
</div>
<br>
  <br>
  <br>
  <!-- list and filter end -->
</section>
<script>
 function loadSingleUser(claimId) {

        $.ajax({
            url: `/distribution/get-claim-by-id/${claimId}`,
            method: "GET",
            success: function(claim) {
				let date = new Date(claim.created_at);
                let formattedDate = `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`;
                let tableBody = `
                    <tr>
                        <td>${claim.id}</td>
                        <td>${claim.article_number}</td>
                        <td>${claim.name}</td>
						<td>${claim.shop_manager == Null ? 'N/A' : $claim->shop_mamager }</td>
                        <td>${claim.invoice}</td>
						<td>${formattedDate}</td>
                        <td>${claim.purchase_date}</td>
                        <td>${claim.article_price}</td>
                        <td>${claim.period}</td>
                        <td>${claim.customer_name}</td>
                        <td>${claim.customer_address}</td>
                        <td>${claim.customer_email}</td>
                        <td>${claim.ptcl_number}</td>
                        <td>${claim.cell}</td>
                        <td>${claim.shops.name}</td>
                        <td>${ claim.status == 0 ? 'Pending' :(claim.status == 1 ? 'Submitted':(claim.status == 2 ? 'Rejected' : (claim.status == 3 ? 'Repair':(claim.status ==4 ? 'Replacement':(claim.status == 5 ? 'Received': (claim.status == 6 ? 'Locally Closed': '')))))) }</td>
                        <td>${claim.is_closed == 0 ? 'No' : 'Yes'}</td>
						<td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
								<li><a href="/distribution/status/update/${claim.id}" class="dropdown-item">Submit</a></li>
                                    <li><a class="dropdown-item" href="/claim/claim-settlement-form/${claim.id}">Report</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                `;
                $("#claim-table tbody").html(tableBody);
            },
            error: function(xhr) {
                console.error("Claim not found", xhr.responseText);
                $("small.search-by-id").html(`Claim not found`);
            }
        });
    }
    $(document).ready(function() {
        $("#search-btn").on("click", function() {
          console.log('ok');
          
            let searchId = $("#search-id").val();
            if (searchId) {
                loadSingleUser(searchId);
            }
        });
    });
</script>
@endsection
