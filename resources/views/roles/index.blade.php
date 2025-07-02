@extends('layouts/app')
@section('content')
<section class="app-user-list mt-4">
  <!-- list and filter start -->
  <div class="card">
    <div class="card-datatable table-responsive pt-0">
      <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <h1 class="mb-0 ml-3">Roles</h1>
        <a href="roles/create" class="btn btn-primary mr-2">Add Role</a>
      </div>
      <table class="shop-type-list-table table">
        <thead class="table-light">
          <tr>
            <th>Name</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($roles as $role)
          <tr>
            <td>{{$role->name ? $role->name : 'N/A'}}</td>
            <td>{{$role->status}}</td>
            <td> 
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Actions
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{{route('roles.edit',$role->id)}}" class="dropdown-item edit">Edit</a></li>
                </ul>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
	      {{ $roles->links() }}
    </div>
  </div>
  <br>
  <br>
  <br>
  <!-- list and filter end -->
</section>
@endsection
