@extends('layouts.master')

@section('title', "Company Detail" )

@section('content')
  @php
  $n = 0;
  @endphp
  <div class="col-sm-4">
    <button type="button" class="btn btn-primary rounded-pill waves-effect waves-light my-2" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editItem(this)" onclick="editItem(this)"
    data-id="{{ ++$n }}" data-did="{{ Helper::hash($company->id) }}"><i class="mdi mdi-pencil"></i>
      Edit Company
    </button>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              @isset($company)
                <p>Name : <b id="name-{{$n}}">{{$company->name}}</b></p>
                <p>Address : <b id="address-{{$n}}">{{$company->address}}</b></p>
                <p>Phone : <b id="phone-{{$n}}">{{$company->phone}}</b></p>
                <p>Description : <b id="desc-{{$n}}">{{$company->desc}}</b></p>
              @endisset
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--Edit Modal Start-->
  <div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header bg-primary">
          <h4 class="modal-title text-white">
            Edit Company Details
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{route('company.user.edit')}}">
            @csrf
            <input type="hidden" id="edit_id" name="edit_id">
            <div class="mb-3 col-12">
              <label for="edit-name" class="form-label">Company Name</label>
              <input class="form-control" type="text" id="edit-name" name="name">
            </div>
            <div class="mb-3 col-12">
              <label for="edit-num">Company Number</label>
              <input type="text" class="form-control" id="edit-num" name="phone">
            </div>
            <div class="mb-3 col-12">
              <label for="edit-address">Company Address</label>
              <input type="text" class="form-control" id="edit-address" name="address">
            </div>
            <div class="mb-3 form-group">
              <label for="edit-description">Company Description</label>
              <textarea class="form-control" id="edit-description" name="desc" rows="2"></textarea>
            </div>
            <div class="modal-footer p-0">
            <button type="submit" class="btn btn-primary float-end">Submit</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>
  <!--Edit Modal End-->
@endsection

<script type="text/javascript">
function editItem(d) {
var keyID = d.getAttribute("data-id");
var dId = d.getAttribute("data-did");
var name = $('#name-'+keyID).text();
var phone = $('#phone-'+keyID).text();
var address = $('#address-'+keyID).text();
var description = $('#desc-'+keyID).text();
$('#edit_id').val(dId);
$('#edit-name').val(name);
$('#edit-num').val(phone);
$('#edit-address').val(address);
$('#edit-description').val(description);
}
</script>
