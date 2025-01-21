@extends('layouts/app')
@section('content')
<section class="bs-validation mt-4">
  <div class="row">
    <div class="col-12">
      <div class="card" style="margin-bottom: 10%;">
        <div class="card-header">
          <h4 class="card-title">Update Shop Status</h4>
        </div>
        <div class="card-body">
        <form action="{{route('shop.updateStatus',$shop->id)}}" method="POST"  class="row">
        @csrf
        @method('PUT')
        <input type="hidden" id="shopId" name="shopId" value="{{$shop->id}}" />
          <div class="col-12">
            <label class="form-label" for="status">Status</label>          
            <select class="select2 w-100 form-control" name="is_active" id="is_active">
                      <option value="">Select Status</option>
                      <option value="1">Active</option>
                      <option value="0">In Active</option>
                    </select>
                    <div>
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary mt-2 me-1">Update</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
