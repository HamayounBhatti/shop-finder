@extends('layouts/app')
@section('vendor-style')
  {{-- Vendor Css files --}}
  <link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-validation.css') }}">
@endsection
@section('content')
<section class="bs-validation mt-4">
  <div class="row">
    <div class="col-12">
      <div class="card" style="margin-bottom: 10%;">
        <div class="card-header">
          <h4 class="card-title">Update Shop</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('claim.update') }}" method="POST">
            @csrf
            @method('PUT')
                <input type="hidden" id="id" name="id" value="{{$branch['id']}}" />
            <div class="row">
            <div class="mb-1 col-md-12">
                <label class="form-label" for="article_number">Article Number</label>
                <input type="text" name="article_number" id="article_number" class="form-control" value="{{ $branch['article_number'] ?? ''}}" placeholder="Enter Article Number" required />
            </div>
            <div class="mb-1 col-md-12">
                <label class="form-label" for="color">Color</label>
                <input type="text" name="color" id="color" class="form-control" placeholder="Enter Shoe Color" value="{{ $branch['color'] ?? ''}}" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="size">Size</label>
                <input type="number" name="size" id="size" min="39" max="46" class="form-control" placeholder="Enter Shoe Size" value="{{ $branch['size'] ?? ''}}" required />
              </div>
            <div class="mb-1 col-md-12">
              <label class="form-label" for="name">Name</label>
              <input type="text" name="name" id="name" class="form-control" value="{{ $branch['name'] ?? ''}}" placeholder="john" required />
            </div>
            <div class="mb-1 col-md-12">
                <label class="form-label" for="invoice">Invoice</label>
                <input type="number" name="invoice" minlength="0" id="invoice" class="form-control" value="{{ $branch['invoice'] ?? ''}}" placeholder="Enter Invoice" required />
            </div>
            <div class="mb-1 col-md-12">
                <label class="form-label" for="purchase_date">Purchase Date</label>
                <input type="date" name="purchase_date" id="purchase_date" class="form-control" value="{{ $branch['purchase_date'] ?? ''}}" placeholder="Enter Purchase Date" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="article_price">Article Price</label>
                <input type="text" name="article_price" id="article_price" class="form-control" value="{{ $branch['article_price'] ?? ''}}" placeholder="Enter Article Price"  required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="period">Period</label>
                <input type="text" name="period" id="period" class="form-control" value="{{ $branch['period'] ?? ''}}" placeholder="Enter Period" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="customer_name">Customer Name</label>
                <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{ $branch['customer_name'] ?? ''}}" placeholder="Enter Customer Name" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="customer_address">Customer Address</label>
                <input type="text" name="customer_address" id="customer_address" class="form-control" value="{{ $branch['customer_address'] ?? ''}}" placeholder="Enter Customer Address" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="customer_email">Customer Email</label>
                <input type="text" name="customer_email" id="customer_email" class="form-control" value="{{ $branch['customer_email'] ?? ''}}" placeholder="Enter Customer Email" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="ptcl_number">Ptcl</label>
                <input type="text" name="ptcl_number" id="ptcl_number" minlength="11" maxlength="11" class="form-control" value="{{ $branch['ptcl_number'] ?? ''}}" placeholder="042 31234567" />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="cell">Cell</label>
                <input type="number" name="cell" id="cell" minlength="11" maxlength="11" class="form-control" value="{{ $branch['cell'] ?? ''}}" placeholder="(472) 765-3654" />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="shop_id">Shops</label>
                <select name="shop_id" id="shop_id" class="form-control">
                  <option value="">Select Shop Name</option>
                  @foreach($shops as $shop)
                    <option value="{{$shop->id}}" {{ $shop->id == $branch['shop_id'] ? 'selected' : '' }}>{{$shop->name}}</option>
                    @endforeach
                </select>
              </div>
              <div class="col-sm-10">
            <div class="col-12 mt-2 mb-2 row">
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
              <div class="col-12">
                <button type="submit" class="btn btn-primary" name="update" value="Update">Update</button>
                <a type="button" href="#" id="back_button" class="btn btn-secondary">Cancel</a>
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
  <!-- vendor files -->
  <script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
  <script src="{{ asset('vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
@endsection

@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset('js/scripts/claim/add-claim.js') }}"></script>

@endsection