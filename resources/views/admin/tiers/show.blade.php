@extends('layouts.master')

@section('title', $role->name)

@section('content')
  <div class="row">
    <div class="col-6">
      <div class="card">
        <div class="card-body">
          <h4 class="header-title">{{$role->name}}'s Access List</h4>
          <p class="sub-header">Assign role access list below</p>
          <form method="POST" action="{{route('tiers.updateRolePermission')}}">
            @csrf
            <input name="role" value="{{$role->HashedId}}" hidden>
            <div class="row">
              <div class="mb-3 col">
            @if ($permissions)
              <div class="form-check">
                <label for="unCheck" class="form-label">Uncheck All</label>
                <input id="unCheck" class="form-check-input" type="checkbox" value="{{Helper::hash(0)}}" name="permission[]" onclick="unCheckItem(this)" {{$role->permissions->count()?'':'checked'}}>
              </div>
            @endif
            @foreach ($permissions as $key => $permission)
              <div class="form-check">
                <label for="{{$permission->HashedId}}" class="form-label">{{$permission->name}}</label>
                <input class="form-check-input" type="checkbox" value="{{$permission->HashedId}}" id="{{$permission->HashedId}}" name="permission[]" {{ $role->hasPermissionTo($permission->name) ? 'checked':''}} data-item-name="permission" onclick="checkItem(this)">
              </div>
            @endforeach
            </div>
            <div class="row">
              <div class="col">
                <button type="submit" class="btn btn-primary float-end">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('add-script')
<script type="text/javascript">

function unCheckItem(d) {
  var checkId = d.getAttribute("id");
  checkboxes = document.querySelectorAll("[data-item-name='permission']");
  if (document.getElementById(checkId).checked) {
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = false;
    }
  }else {
    document.getElementById("unCheck").checked = true;
  }
}


function checkItem(d) {
  var checkId = d.getAttribute("id");
  var checkboxes = $("input[data-item-name='permission']:checkbox");
  if (document.getElementById(checkId).checked) {
    if (checkboxes.not(":checked").length > 0)  {
      document.getElementById("unCheck").checked = false;
    }
  }
  else {
    // if all checkbox not checked, set unCheck true
    if (checkboxes.not(":checked").length == checkboxes.length)  {
      document.getElementById("unCheck").checked = true;
    }
  }
}

</script>
@endsection
