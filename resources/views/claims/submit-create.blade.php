@extends('layouts/app')
@section('content')
<section class="bs-validation mt-4">
  <div class="row">
    <div class="col-12">
      <div class="card" style="margin-bottom: 10%;">
        <div class="card-header">
          <h4 class="card-title">Submit Claim<small>(Shop Side)</small></h4>
        </div>
        <div class="card-body">
        <form action="{{route('claim.submitRecord')}}" method="POST" class="row">
          @csrf
          @method('PUT')
          <input type="hidden" id="claimId" name="claimId" value="{{$claim->id}}" />
          <div class="form-group">
            <label for="name" class="col-form-label">Name:</label>
            <input type="text" name="claimName" class="form-control" id="claimName" value="{{$claim->name}}">
          </div>
          <div class="form-group">
            <label for="message" class="col-form-label">Nature Of Complaint</label>
            <textarea class="form-control" name="message" id="message"></textarea>
          </div>
          <div class="col-sm-10">
            <div class="col-12 mt-2 row">
              <div class="col-6">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="status" id="gridRadios1" value="1" checked>
                  <label class="form-check-label" for="gridRadios1">
                    Accepted
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 text-center mt-2">
            <button type="submit" class="btn btn-primary me-1">Submit</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection