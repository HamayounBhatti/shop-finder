@extends('layouts/app')
@section('content')
<section class="bs-validation">
  <br>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Add Role</h4>
        </div>
        <div class="card-body">
            <form action="{{route('roles.store')}}" method="POST">
            <div class="row">
              @csrf
              <div class="mb-1 col-md-12">
                <label class="form-label" for="name">Role Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Role Name" required />
              </div>
              @foreach($permissions as $permission)
                <div class="permission-group">
                    <label><input type="checkbox" name="permissions[]" value="{{$permission->id}}"> {{$permission->name}}</label>
                </div>
              @endforeach
              <!-- <div class="mb-1 col-md-12">
                <label class="form-label" for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="abc@mailinator.com" />
              </div>

              <div class="mb-1 col-md-12">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="********" />
              </div> -->

              <div class="col-12">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<br><br><br>
<script>
    function savePermissions() {
            const checkboxes = document.querySelectorAll('input[name="permissions"]:checked');
            let selectedPermissions = [];
            checkboxes.forEach((checkbox) => {
                selectedPermissions.push(checkbox.value);
            });

            if (selectedPermissions.length === 0) {
                alert("Please select at least one permission.");
            } else {
                alert("Permissions saved: " + selectedPermissions.join(", "));
                // You can send the data to a server via AJAX here
            }
        }
</script>
@endsection