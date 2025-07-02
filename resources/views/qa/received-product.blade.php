@extends('layouts/app')
@section('content')
<section class="bs-validation mt-4">
  <div class="row">
    <div class="col-12">
      <div class="card" style="margin-bottom: 10%;">
        <div class="card-header">
          <h4 class="card-title">Received Product</h4>
        </div>
        <div class="card-body">
        <form action="{{route('qa.qaReceivedClaim')}}" method="post" class="row">
          @csrf
          @method('PUT')
          <input type="hidden" id="receivedId" name="receivedId" value="{{$claim->id}}" />
          <div class="form-group">
            <label for="name" class="col-form-label">Aritcle Name:</label>
            <input type="text" name="receivedName" class="form-control" id="receivedName" value="{{$claim->name}}" disabled>
          </div>
          <div class="form-group">
            <label for="received_remarks" class="col-form-label">Received Remarks:</label>
            <textarea class="form-control" name="received_remarks" id="received_remarks"></textarea>
          </div>
          <div class="form-group">
            <label for="received_date_and_time" class="col-form-label">Received Date And Time</label>
            <input type="text" name="receiveddateandtime" class="form-control" id="receiveddateandtime" value="{{ \Carbon\Carbon::now()}}" disabled>
            <input type="hidden" id="received_date_and_time" name="received_date_and_time" value="{{ \Carbon\Carbon::now()}}" />
          </div>
          <div class="col-sm-10">
            <div class="col-12 mt-2 row">
              <div class="col-4">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="is_received" id="gridRadios1" value="1" checked>
                  <label class="form-check-label" for="gridRadios1">
                    Received
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