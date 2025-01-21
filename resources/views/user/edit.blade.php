@extends('layouts/app')
@section('content')
<section class="bs-validation mt-4">
  <div class="row">
    <div class="col-12">
      <div class="card" style="margin-bottom: 10% !important;">
        <div class="card-header">
          <h4 class="card-title">Update User</h4>
        </div>
        <div class="card-body">
        <form action="{{route('user.update')}}" method="POST">
          <input type="hidden" id="id" name="id" value="{{$branch['id']}}" />
            <div class="row">
              @csrf
              @method('PUT')
              <div class="mb-1 col-md-12">
                <label class="form-label" for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" value="{{ $branch['name'] ?? ''}}" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="user_name">User Name</label>
                <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter User Name" value="{{ $branch['user_name'] ?? ''}}" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" value="{{ $branch['email'] ?? ''}}" />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="email">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="role_id">Role</label>
                  <select id="role_id" name="role_id" class="form-control">
                      <option value="">Select an option</option>
                      <!-- Dynamically generated options -->
                      @foreach ($roles as $role)
                          <option value="{{ $role->id }}" {{ $role->id == old('role_id', $branch->role_id) ? 'selected' : '' }}>
                            {{ $role->name }}
                          </option>
                      @endforeach
                  </select>
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="shop_id" >Shop</label>
                <select id="shop_id" name="shop_id" class="form-control" value="{{ $branch['shop_id'] ?? ''}}" selected>
                      <option value="">Select an option</option>
                      <!-- Dynamically generated options -->
                      @foreach ($shops as $shop)
                          <option value="{{ $shop->id }}" {{ $shop->id == old('shop_id', $branch->shop_id) ? 'selected' : '' }}>
                            {{ $shop->name }}
                          </option>
                      @endforeach
                  </select>
              </div>
              <div class="col-12 mt-2">
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