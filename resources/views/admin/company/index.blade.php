@extends('layouts.master')

@section('title', Auth::user()->name."'s Dashboard" )

@section('breadcrumb')
  <li class="breadcrumb-item">
    <a href="{{ route('dashboard') }}">
    Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Company List</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="header-title">Company List</h4>
          <div>
              <a type="button" class="btn btn-primary rounded-pill waves-effect waves-light m-1" data-bs-toggle="modal" data-bs-target="#addModal"><i class="mdi mdi-plus"></i> Add Company</a>
          </div>
          <div class="table-responsive">
            <table id="basic-datatable" class="table nowrap w-100">
              <thead>
                <tr>
                  @php
                  $titleArr = ['#' , 'Company ID' ,'Company Name' , 'Company Number' , 'Company Adress' ,'Description', 'Action'];
                  @endphp
                  @foreach ($titleArr as $key => $value)
                    <th>{{$value}}</th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                @php
                $n = 0;
                @endphp
                @isset ($company)
                  @foreach ($company as $key => $comp)
                    <tr>
                      <td>{{ ++$n }}</td>
                      <td>{{Helper::hash($comp->id)}}</td>
                      <td id="name-{{$n}}">{{$comp->name}}</td>
                      <td id="phone-{{$n}}">{{$comp->phone}}</td>
                      <td id="address-{{$n}}" class="align-middle">{{$comp->address}}</td>
                      <td id="desc-{{$n}}" class="align-middle">{{$comp->desc}}</td>
                      <td>
                        <div class="dropdown btn-group dropstart">
                          <button class="btn btn-xs btn-light btn-outline-blue dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-list"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-center">
                            <button title="Show" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#viewModal" onclick="detailItem(this)" data-id="{{ $n }}"><i class="fe-eye"></i> View</button>
                            <button title="Update" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editItem(this)"
                            data-id="{{ $n }}" data-did="{{ Helper::hash($comp->id) }}"><i class="mdi mdi-pencil"></i> Edit</button>
                            <button onclick="deleteItem(this)" title="Delete" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-del-title="{{$comp->name}}" data-keyid="{{Helper::hash($comp->id)}}"><i class="fe-trash-2"></i> Delete</button>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                @endisset
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- View Modal begin --}}
  <div class="modal fade" id="viewModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title text-white">Company Details</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group row">
              <label for="detail-name" class="col-sm-2 col-form-label">Company Name</label>
              <div class="col-sm-6">
                <p id="detail-name" class="col-form-label">Name</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="detail-num" class="col-sm-2 col-form-label">Company Number</label>
              <div class="col-sm-6">
                <p id="detail-num" class="col-form-label">Number</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="detail-address" class="col-sm-2 col-form-label">Company Address</label>
              <div class="col-sm-6">
                <p id="detail-address" class="col-form-label">IMEI</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="detail-description" class="col-sm-2 col-form-label">Description</label>
              <div class="col-sm-6">
                <p id="detail-description" class="col-form-label">Description</p>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  {{-- View Modal end --}}

  <!--Add Modal Start-->
  <div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header bg-primary">
          <h4 class="modal-title text-white">
            Company Details
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{route('company.store')}}">
            @csrf
            <div class="mb-3 col-12">
              <label for="name" class="form-label">Company Name</label>
              <input class="form-control" type="text" name="name" id="name">
            </div>
            <div class="mb-3 col-12">
              <label for="phone">Company Number</label>
              <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <div class="mb-3 col-12">
              <label for="address">Company Address</label>
              <textarea class="form-control" id="address" name="address" rows="2"></textarea>
            </div>
            <div class="mb-3 col-12">
              <label for="desc">Description</label>
              <textarea class="form-control" id="desc" name="desc" rows="2"></textarea>
            </div>
            {{-- <div class="input-group mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Owners</label>
              </div>
              <select class="custom-select col-10" id="inputGroupSelect01">
                <option selected>Choose...</option>
                <option value="1">Marco</option>
                <option value="2">Polo</option>
                <option value="3">Chenggis</option>
              </select>
            </div> --}}
            <div class="modal-footer p-0">
            <button type="submit" class="btn btn-primary float-end">Submit</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--Add Modal End-->

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
        <form method="POST" action="{{route('company.edit')}}">
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

{{-- Delete Modal begin --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-dark-theme">
      <form method="POST" action="{{route('company.destroy')}}">
        @csrf
        <div class="modal-header text-uppercase bg-light">
          <h5 class="modal-title">Delete Company</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p id="del_msg"></p>
          <input type="hidden" name="delete_id" id="delete_id">
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Confirm</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- Delete Modal end --}}
@endsection

@section('add-css')
  <link href="{{ asset('scripts/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Javascript --}}
@section('add-script')

  <script src="{{ asset('scripts/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('scripts/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>

  {{-- <script src="{{ asset('js/pages/datatables.init.js') }}"></script> --}}
  <script type="text/javascript">

  $("#basic-datatable").one("preInit.dt", function () {

  $button = $('<div class="dropdown btn-group dropstart" title="Columns">'
  +'<button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-label="Columns" title="Columns" aria-expanded="false">'
  +'<i class="fa fa-th-list"></i>'
  +'<span class="caret"></span>'
  +'</button>'
  +'<div class="dropdown-menu dropdown-menu-right" style="">'
  @foreach($titleArr as $key => $value)
  +'<label class="dropdown-item dropdown-item-marker" data-column="{{$key}}" onclick="columnToggle(event,this)"><input type="checkbox" data-field="id" value="{{$key}}" checked="checked" class="float:left"> <span>{{$value}}</span></label>'
  @endforeach
  +'</div></div>');
  $("#basic-datatable_filter label").append($button);
  // $button.button();

  });

  $("#basic-datatable").DataTable({
  language: {
  paginate: {
  previous: "<i class='mdi mdi-chevron-left'>",
  next: "<i class='mdi mdi-chevron-right'>"
  }
  },

  drawCallback: function() {
  $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
  },
  lengthChange: !1,
  buttons: [{
  extend: "copy",
  className: "btn btn-light btn-xs",
  exportOptions: { columns: 'th:not(:last-child)' },
  title: 'Company-List'
  },
  {
  extend: "csv",
  className: "btn btn-light btn-xs",
  exportOptions: { columns: 'th:not(:last-child)' },
  title: 'Company-List'
  },
  {
  extend: "excel",
  className: "btn btn-light btn-xs",
  exportOptions: { columns: 'th:not(:last-child)' },
  title: 'Company-List'
  },
  {
  extend: "print",
  className: "btn btn-light btn-xs",
  exportOptions: { columns: 'th:not(:last-child)' },
  title: 'Company-List'
  }, {
  extend: "pdf",
  className: "btn btn-light btn-xs",
  exportOptions: { columns: 'th:not(:last-child)' },
  title: 'Company-List'
  }]
  }).buttons().container().appendTo("#basic-datatable_wrapper .col-md-6:eq(0)");

  function columnToggle(e,d) {
  e.preventDefault();
  // e.stopPropagation();

  if ($("input[value='" + d.getAttribute("data-column") + "']").is(':checked')) {
  $("input[value='" + d.getAttribute("data-column") + "']").prop('checked', false);
  }else {
  $("input[value='" + d.getAttribute("data-column") + "']").prop('checked', true);
  }
  var column = $('#basic-datatable').DataTable().column( d.getAttribute("data-column") );

  column.visible( ! column.visible() );
  }

  $('#basic-datatable_wrapper').css('min-height','500px');

</script>



<script type="text/javascript">

//view Details
function detailItem(d) {
var keyID = d.getAttribute("data-id");
var name = $('#name-'+keyID).text();
var phone = $('#phone-'+keyID).text();
var address = $('#address-'+keyID).text();
var desc = $('#desc-'+keyID).text();
$('#detail-name').text(name);
$('#detail-num').text(phone);
$('#detail-address').text(address);
$('#detail-description').text(desc);
}

//Reg Details
function regItem(d) {
var keyID = d.getAttribute("data-id");
var name = $('#name-'+keyID).text();
var address = $('#address-'+keyID).text();
$('#reg-name').text(name);
$('#reg-address').text(address);
}

//edit Details
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

//Delete Details
function deleteItem(d) {
  var keyID = d.getAttribute("data-keyid");
  var keyTitle = d.getAttribute("data-del-title");
  var shwMsg = document.getElementById("del_msg");
  shwMsg.innerHTML = "Are you sure you wish to delete <strong>"+keyTitle+"</strong>?";
  $('#delete_id').val(keyID);
  $('#deleteModal').modal('show');
}
</script>

@endsection
