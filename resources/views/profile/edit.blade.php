@extends('layouts/app')
@section('content')
<section class="bs-validation mt-4">
  <div class="row">
    <div class="col-12">
      <div class="card" style="margin-bottom: 10% !important;">
        <div class="card-header">
          <h4 class="card-title">Edit Profile</h4>
        </div>
        <div class="card-body">
        <form action="{{route('profile.update')}}" method="POST">
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
                <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter User Name" value="{{ $branch['username'] ?? ''}}" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" value="{{ $branch['email'] ?? ''}}" />
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
