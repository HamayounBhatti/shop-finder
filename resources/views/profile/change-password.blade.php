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
        <form action="{{route('profile.password.update')}}" method="POST">
          <input type="hidden" id="id" name="id" value="{{$branch['id']}}" />
            <div class="row">
              @csrf
              @method('PUT')
              <div class="mb-1 col-md-12">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required />
              </div>
              <div class="mb-1 col-md-12">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Enter Confirm Password" required />
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
