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
    <h1 class="mb-0 ml-3">Claims</h1>
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
                        <td>
                          @if($claim->invoice_image == null)
                          {{ $claim->invoice }}
                          @else
                          {{ $claim->invoice }}
                          <img src="{{asset('storage/' . $claim->invoice_image)}}" alt="Invoice Image" class="img-thumbnail dynamic-img" style="cursor: pointer;" width="150" data-bs-toggle="modal" data-bs-target="#imageModal" 
                            data-src="{{asset('storage/' . $claim->invoice_image)}} "></img>
                          @endif
                        </td>
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
						<td>{{ $claim->is_closed == 0 ? 'No' :'Yes'}}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                @if($claim->status == 1)
                                <li><a href="{{route('qa.createReceivedClaim',$claim->id)}}" class="dropdown-item">Received</a></li>
                                @else
                                <li><a href="{{route('qa.createSubmitRecord',$claim->id)}}" class="dropdown-item">Submit</a></li>
                                @endif
                                <li><a href="{{route('qa.gallary',$claim->id)}}" class="dropdown-item gallary" data-type_id="{{$claim->id}}">Gallary</a></li>
								<li><a class="dropdown-item" href="{{route('qa.claim.settlement.form',$claim->id)}}">Report</a></li>
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

@include('qa/modals/invoice_image_modal')
<script>
 function loadSingleUser(claimId) {

        $.ajax({
            url: `/qa/get-claim-by-id/${claimId}`,
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
                        <td>
							${claim.invoice_image == null ? claim.invoice : claim.invoice +'<img src="{{asset('storage/' . $claim->invoice_image)}}" alt="Invoice Image" class="img-thumbnail dynamic-img" style="cursor: pointer;" width="150" data-bs-toggle="modal" data-bs-target="#imageModal" data-src="{{asset('storage/' . $claim->invoice_image)}} "></img>'}
						</td>
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
								${claim.status == 1 ?
										 '<li><a href="/qa/received/product/${claim.id}" class="dropdown-item">Received</a></li>'
									 
									:
										 
										'<li><a href="qa/status/update/${claim.id}" class="dropdown-item">Submit</a></li>'
									 }
										<li><a href="/qa/gallary/${claim.id}" class="dropdown-item gallary" data-type_id="${claim.id}">Gallary</a></li>
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
