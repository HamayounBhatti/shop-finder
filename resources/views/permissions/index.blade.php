@extends('layouts/app')
@section('content')
<section class="app-user-list mt-4">
  <!-- list and filter start -->
  <div class="card">
    <div class="card-datatable table-responsive pt-0">
      <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <h1 class="mb-0 ml-3">Permissions</h1>
        <!-- <a href="roles/create" class="btn btn-primary mr-2">Add Permission</a> -->
      </div>
      <table class="shop-type-list-table table">
        <thead class="table-light">
          <tr>
            <th>Name</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($permissions as $permission)
          <tr>
            <td>{{$permission->name ? $permission->name : 'N/A'}}</td>
            <td>Active</td>
          </tr>
          @endforeach
        </tbody>
      </table>
	      {{ $permissions->links() }}
    </div>
  </div>
  <br>
  <br>
  <br>
  <!-- list and filter end -->
</section>
@endsection
