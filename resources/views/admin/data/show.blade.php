@extends('layouts.master')

@section('title', $company->name)

@section('content')
  <div class="row">
    <div class="col-6">
      <div class="card">
        <div class="card-body">
          <h4 class="header-title">{{$company->name}}'s Access List</h4>
          <p class="sub-header">Assign role access list below</p>
          <form method="POST" action="#">
            @csrf
            <input name="role" value="{{$company->HashedId}}" hidden>
            <div class="row">
              <div class="mb-3 col">
            @if ($columns)
              <div class="form-check">
                <label for="unCheck" class="form-label">Uncheck All</label>
                <input id="unCheck" class="form-check-input" type="checkbox" value="{{Helper::hash(0)}}" name="column[]" onclick="unCheckItem(this)" {{--$company->columns->count()?'':'checked'--}}>
              </div>
            @endif
            @foreach ($columns as $key => $column)
              <div class="form-check">
                <label for="{{$column.$key}}" class="form-label">{{$column}}</label>
                <input class="form-check-input" type="checkbox" value="{{$column}}" id="{{$column.$key}}" name="column[]" {{-- $company->hascolumnTo($column->name) ? 'checked':''--}} data-item-name="column" onclick="checkItem(this)">
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

</script>
@endsection
