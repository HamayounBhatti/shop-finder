@extends('layouts/app')
@section('content')
<section class="app-user-list mt-4">
  <!-- list and filter start -->
  <div class="card">
    <div class="card-datatable table-responsive pt-0">
      <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <h1 class="mb-0 ml-3">Users</h1>
        <a href="user/create" class="btn btn-primary mr-2">Add User</a>
      </div>
      <table class="shop-type-list-table table">
        <thead class="table-light">
          <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Shop</th>
            <th>Actions</th>
          </tr>
        </thead>
        @if(!$users->isEmpty())
        <tbody>
          @foreach ($users as $user)
          <tr>
            <td>{{$user->name ? $user->name : 'N/A'}}</td>
            <td>{{$user->username ? $user->username : 'N/A'}}</td>
            <td>{{$user->email ? $user->email : 'N/A'}}</td>
            <td>{{$user->role ? $user->role->name : 'N/A'}}</td>
            <td>{{$user->shop ? $user->shop->name : 'N/A'}}</td>
            <td> 
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Actions
                </button>
                <ul class="dropdown-menu">
                    <li><a href="{{route('user.edit',$user->id)}}" class="dropdown-item edit">Edit</a></li>
                </ul>
              </div>
            </td>
          </tr>
          @endforeach
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

