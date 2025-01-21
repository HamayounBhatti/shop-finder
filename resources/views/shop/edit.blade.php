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
<section class="bs-validation">
  <br>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Update Shop</h4>
        </div>
        <div class="card-body">
            <form action="{{route('shop.update')}}" method="POST">
              @csrf
              @method('PUT')
                <input type="hidden" id="id" name="id" value="{{$branch['id']}}" />
            <div class="row">
            <div class="mb-1 col-md-12">
              <label class="form-label" for="name">Name</label>
              <input type="text" name="name" id="name" class="form-control" value="{{ $branch['name'] ?? ''}}" placeholder="john" required />
            </div>

            <div class="mb-1 col-md-12">
              <label class="form-label" for="mobile_no">Shop Number</label>
              <input type="text" name="shop_number" id="shop_number" class="form-control"  value="{{ $branch['shop_number'] ?? ''}}" placeholder="(472) 765-3654" />
            </div>
            <div class="mb-1 col-md-12">
              <label class="form-label" for="address">Address</label>
              <input type="text" name="address" id="address" class="form-control" value="{{ $branch['address'] ?? ''}}" placeholder="Your Address" />
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
  <script src="{{ asset('js/scripts/shop/add-shop.js') }}"></script>
@endsection