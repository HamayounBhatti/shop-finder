@extends('layouts/app')
@section('vendor-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css') }}">
@endsection
@section('content')
<section class="app-user-list mt-4">
  <!-- list and filter start -->
  <div class="card">
    <div class="card-datatable table-responsive pt-0">
      <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <h1 class="mb-0 ml-3">Shops</h1>
        <a href="shop/create" class="btn btn-primary mr-2">Add Shop</a>
      </div>
      <table class="shop-type-list-table table">
        <thead class="table-light">
          <tr>
            <th>Name</th>
            <th>Shop Number</th>
            <th>Address</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($shops as $shop)
          <tr>
            <td>{{$shop->name ? $shop->name : 'N/A'}}</td>
            <td>{{$shop->shop_number ? $shop->shop_number : 'N/A'}}</td>
            <td>{{$shop->address ? $shop->address : 'N/A'}}</td>
            <td>{{$shop->is_active == 1 ? 'Active' : 'Not Active'}}</td>
            <td> 
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Actions
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{{route('shop.edit',$shop->id)}}" class="dropdown-item edit">Edit</a></li>
                    <li><a href="{{route('shop.createSubmitRecord',$shop->id)}}" class="dropdown-item edit">Status Update</a></li>
                </ul>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
	      {{ $shops->links() }}
    </div>
  </div>
  <br>
  <br>
  <br>
  <!-- list and filter end -->
</section>
@endsection
