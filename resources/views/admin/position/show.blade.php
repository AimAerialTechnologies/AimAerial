@extends('layouts.master')

@section('title', $position->name)

@section('content')
  <div class="row">
    <div class="col-6">
      <div class="card">
        <div class="card-body">
          <h4 class="header-title">{{$position->name}}'s Drone Data Access</h4>
          <p class="sub-header">Assign drone access list below</p>
          <form method="POST" action="{{route('position.updateDataAccess')}}">
            @csrf
            <input name="position" value="{{$position->HashedId}}" hidden>
            <div class="row">
              <div class="mb-3 col">
            @if ($columns)
              <div class="form-check">
                <label for="unCheck" class="form-label">Uncheck All</label>
                <input id="unCheck" class="form-check-input" type="checkbox" value="{{Helper::hash(0)}}" name="dataaccess[]" onclick="unCheckItem(this)" {{count($dataAccess) ?'':'checked'}}>
              </div>
            @endif
            @foreach ($columns as $key => $column)
              <div class="form-check">
                <label for="{{$column.$key}}" class="form-label">{{$column}}</label>
                <input class="form-check-input" type="checkbox" value="{{$column}}" id="{{$column.$key}}" name="dataaccess[]" {{ in_array($column,$dataAccess) ? 'checked':''}} data-item-name="column" onclick="checkItem(this)">
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
  <div class="col-6">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title">{{$position->name}}'s View Data Access</h4>
        <p class="sub-header">Assign page access list below</p>
        <form method="POST" action="{{route('position.updateDataMenu')}}">
          @csrf
          <input name="position" value="{{$position->HashedId}}" hidden>
          <div class="row">
            <div class="mb-3 col">
          @if ($column_menus)
            <div class="form-check">
              <label for="unCheckMenu" class="form-label">Uncheck All</label>
              <input id="unCheckMenu" class="form-check-input" type="checkbox" value="{{Helper::hash(0)}}" name="datamenu[]" onclick="unCheckItemMenu(this)" {{count($dataMenu) ?'':'checked'}}>
            </div>
          @endif
          @foreach ($column_menus as $key => $menu)
            <div class="form-check">
              <label for="{{$menu.$key}}" class="form-label">{{$menu}}</label>
              <input class="form-check-input" type="checkbox" value="{{$menu}}" id="{{$menu.$key}}" name="datamenu[]" {{ in_array($menu,$dataMenu) ? 'checked':''}} data-item-name="column-menu" onclick="checkItemMenu(this)">
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
  checkboxes = document.querySelectorAll("[data-item-name='column']");
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
  var checkboxes = $("input[data-item-name='column']:checkbox");
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


function unCheckItemMenu(d) {
  var checkId = d.getAttribute("id");
  checkboxes = document.querySelectorAll("[data-item-name='column-menu']");
  if (document.getElementById(checkId).checked) {
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = false;
    }
  }else {
    document.getElementById("unCheckMenu").checked = true;
  }
}

function checkItemMenu(d) {
  var checkId = d.getAttribute("id");
  var checkboxes = $("input[data-item-name='column-menu']:checkbox");
  if (document.getElementById(checkId).checked) {
    if (checkboxes.not(":checked").length > 0)  {
      document.getElementById("unCheckMenu").checked = false;
    }
  }
  else {
    // if all checkbox not checked, set unCheck true
    if (checkboxes.not(":checked").length == checkboxes.length)  {
      document.getElementById("unCheckMenu").checked = true;
    }
  }
}

</script>
@endsection
