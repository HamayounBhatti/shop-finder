@extends('layouts/app')

@section('vendor-style')
  {{-- Vendor CSS files --}}
  <link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
@endsection

@section('page-style')
  {{-- Page CSS files --}}
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-validation.css') }}">
@endsection

@section('content')
<section class="bs-validation mt-4">
  <div class="row" >
    <div class="col-12">
      <div class="card" style="margin-bottom: 10%;">
        <div class="card-header">
          <h4 class="card-title">Add Claim</h4>
        </div>
        <div class="card-body">
          <form id="jquery-val-form"  action="{{ route('claim.store') }}" method="POST" enctype="multipart/form-data">
            <div class="row">
              @csrf
              <div class="mb-1 col-md-12">
                <label class="form-label" for="article_number">Article Number</label>
				<small class="text-danger">Please Enter Article Number In The Numeric Format</small>
                <input type="text" name="article_number" id="article_number" class="form-control" placeholder="Enter Article Number" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="color">Color</label>
                <input type="text" name="color" id="color" class="form-control" placeholder="Enter Shoe Color" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="size">Size</label>
				<small class="text-danger">Please Enter Shoe Size In Between 31 To 46</small>
                <input type="number" name="size" id="size" min="31" max="46" class="form-control" placeholder="Enter Shoe Size" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="name">Article Name</label>
				<small class="text-danger">Please Enter Article Name In This Given Format (XX-XX-XXXX)</small>
                <input type="text" name="name" id="name" class="form-control" minlength="5" placeholder="Enter Full Article Name" pattern="[A-Z]{2}-[A-Z]{2}-\d{4}" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="invoice">Invoice</label>
                <input type="number" name="invoice" id="invoice" minlength="0" class="form-control" placeholder="Enter Invoice" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="purchase_date">Purchase Date</label>
				<small class="text-danger">Please Select Purchase Date In This Given Format (XX/XX/XXXX)</small>
                <input type="date" name="purchase_date" id="purchase_date" class="form-control" pattern="\d{2}/\d{2}/\d{4}" placeholder="Enter Purchase Date" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="article_price">Article Price</label>
                <input type="text" name="article_price" id="article_price" class="form-control" placeholder="Enter Article Price" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="period">Period</label>
                <input type="text" name="period" id="period" class="form-control" placeholder="Enter Period" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="customer_name">Customer Name</label>
                <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Enter Customer Name" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="customer_address">Customer Address</label>
                <input type="text" name="customer_address" id="customer_address" class="form-control" placeholder="Enter Customer Address" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="customer_email">Customer Email</label>
                <input type="text" name="customer_email" id="customer_email" class="form-control" placeholder="Enter Customer Email" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="ptcl_number">Ptcl</label>
                <input type="number" name="ptcl_number" id="ptcl_number" class="form-control" placeholder="XXX-XXXXXXX" />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="cell">Cell</label>
                <input type="number" name="cell" id="cell" class="form-control" minlength="11" maxlength="11" placeholder="03XX-XXXXXXX" />
              </div>
			  <div class="mb-1 col-md-12">
                <label class="form-label" for="shop_manager">Shop Manager</label>
                <input type="text" name="shop_manager" id="shop_manager" class="form-control" placeholder="Enter Shop Manager Name" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="shop_id">Shop</label>
                <select name="shop_id" id="shop_id" class="form-control">
                  <option value="">Select Shop Name</option>
                  @foreach($shops as $shop)
                    <option value="{{$shop->id}}">{{$shop->name}}</option>
                    @endforeach
                </select>
              </div>
              <div class="mb-1 col-md-12">
              <label for="image">Upload Invoice Image:</label>
              <input type="file" name="invoice_image" id="invoice_image" class="form-control" accept="image/*" required>
              </div>
              <div class="mb-1 col-md-12">
              <label for="image">Upload Defected Shoes Image:</label>
              <input type="file" name="defect_image[]" id="defect_image" class="form-control" accept="image/*" multiple>
              </div>
            <div class="col-sm-10">
            <div class=" col-12 mt-2 mb-2 row">
              <div class="col-6">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="proposed_status" id="gridRadios1" value="0" checked>
                  <label class="form-check-label" for="gridRadios1">
                    Repair
                  </label>
                </div>
                </div>
                <div class="col-6">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="proposed_status" id="gridRadios1" value="1">
                  <label class="form-check-label" for="gridRadios1">
                    Replacement
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="mb-1 col-md-12">
              <div class="col-12">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('vendor-script')
  <!-- Vendor JS files -->
  <script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
@endsection

@section('page-script')
  <!-- Page JS files -->
  <script src="{{ asset('js/scripts/claim/add-claim.js') }}"></script>
@endsection
