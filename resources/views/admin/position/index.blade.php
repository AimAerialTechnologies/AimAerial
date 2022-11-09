@extends('layouts.master')

@section('title', "Position List" )

@section('breadcrumb')
  <li class="breadcrumb-item">
    <a href="{{ route('dashboard') }}">
    Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Position List</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          @role ('Regulator')
          @if (auth()->user()->company)
            <h4 class="header-title">{{auth()->user()->company->name}}`s Position List</h4>
          @else
            <h4 class="header-title">Position List</h4>
          @endif
          @endrole
        <div class="col-sm-4 mb-2">
          <button type="button" class="btn btn-primary rounded-pill waves-effect waves-light my-2" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="mdi mdi-plus"></i>
            Create New Position
          </button>
        </div>
          <div class="table-responsive">
            <table id="basic-datatable" class="table nowrap w-100">
              <thead>
                <tr>
                  @php
                  $titleArr = ['#' , 'Position ID', 'Name', 'Action'];
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
                @isset ($positions)
                  @foreach ($positions as $key => $position)
                    <tr>
                      <td>{{ ++$n }}</td>
                      <td>{{Helper::hash($position->id)}}</td>
                      <td id="name-{{$n}}">{{$position->name}}</td>
                      <td>
                        <div class="dropdown btn-group dropstart mb-2">
                          <button class="btn btn-xs btn-light btn-outline-blue dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-list"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-center">
                            <a href="{{ route('position.show',
                            ['position' => $position->HashedId]) }}" title="View" class="dropdown-item"><i class="fe-eye"></i> View</a>
                            <button title="Edit" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editItem(this)"
                                    data-id="{{ $n }}" data-did="{{ Helper::hash($position->id) }}"><i class="mdi mdi-pencil"></i> Edit</button>
                            <button onclick="deleteItem(this)" title="Delete" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-del-title="{{$position->name}}" data-keyid="{{Helper::hash($position->id)}}"><i class="fe-trash-2"></i> Delete</button>
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
          <h4 class="modal-title text-white">Position Details</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group row">
              <label for="detail-image" class="col-sm-2 col-form-label">Model Image</label>
              <div class="col-sm-6">
                <img src="" id="detail-image" class="col-form-label" width="50" height="50"></p>
              </div>
            </div>
            <div class="form-group row">
              <label for="detail-model" class="col-sm-2 col-form-label">Model Name</label>
              <div class="col-sm-6">
                <p id="detail-model" class="col-form-label">Name</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="detail-serial_num" class="col-sm-2 col-form-label">Serial Number</label>
              <div class="col-sm-6">
                <p id="detail-serial_num" class="col-form-label">Serial Number</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="detail-imei" class="col-sm-2 col-form-label">IMEI</label>
              <div class="col-sm-6">
                <p id="detail-imei" class="col-form-label">IMEI</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="detail-description" class="col-sm-2 col-form-label">Description</label>
              <div class="col-sm-6">
                <p id="detail-description" class="col-form-label">Description</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="detail-Owner" class="col-sm-2 col-form-label">Owner</label>
              <div class="col-sm-6">
                <p id="detail-owner" class="col-form-label">Owner</p>
              </div>
            </div>
            <div class="form-group row">
              <label for="detail-status" class="col-sm-2 col-form-label">Status</label>
              <div class="col-sm-6">
                <p id="detail-status" class="col-form-label">Status</p>
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
            Add Position
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{route('position.store')}}" enctype="multipart/form-data" >
            @csrf
            <div class="mb-3 col-12">
              <label for="model" class="form-label">Position Name</label>
              <input class="form-control" type="text" name="name" id="model" required>
            </div>

            <div class="mb-3 col">
              <div class="form-check">
                <label for="unCheck" class="form-label">Uncheck All</label>
                <input id="unCheck" class="form-check-input" type="checkbox" value="{{Helper::hash(0)}}" name="dataaccess[]" onclick="unCheckItem(this)">
              </div>
              @foreach ($columns as $key => $column)
                <div class="form-check">
                  <label for="{{$column.$key}}" class="form-label">{{$column}}</label>
                  <input class="form-check-input" type="checkbox" value="{{$column}}" id="{{$column.$key}}" name="dataaccess[]" data-item-name="column" onclick="checkItem(this)">
                </div>
              @endforeach
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

<!--Edit Modal Start-->
<div class="modal fade" id="editModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header bg-primary">
        <h4 class="modal-title text-white">
          Edit Position
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('position.update')}}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="edit_id" name="edit_id">
          <div class="mb-3 col-12">
            <label for="edit-name" class="form-label">Position Name</label>
            <input class="form-control" type="text" name="name" id="edit-name">
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

{{-- Delete Modal begin --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-dark-theme">
      <form method="POST" action="{{route('position.destroy')}}">
        @csrf
        <div class="modal-header text-uppercase bg-light">
          <h5 class="modal-title">Delete Position</h5>
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
  title: 'Position List'
  },
  {
  extend: "csv",
  className: "btn btn-light btn-xs",
  exportOptions: { columns: 'th:not(:last-child)' },
  title: 'Position List'
  },
  {
  extend: "excel",
  className: "btn btn-light btn-xs",
  exportOptions: { columns: 'th:not(:last-child)' },
  title: 'Position List'
  },
  {
  extend: "print",
  className: "btn btn-light btn-xs",
  exportOptions: { columns: 'th:not(:last-child)' },
  title: 'Position List'
  }, {
  extend: "pdf",
  className: "btn btn-light btn-xs",
  exportOptions: { columns: 'th:not(:last-child)' },
  title: 'Position List'
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

    // View Details
    function detailItem(d) {
    var keyID = d.getAttribute("data-id");
    var image = $('#image-'+keyID).text();
    var name = $('#name-'+keyID).text();
    $('#detail-name').text(name);

  }

    //edit Details
    function editItem(d) {
    var keyID = d.getAttribute("data-id");
    var dId = d.getAttribute("data-did");
    var name = $('#name-'+keyID).text();
    $('#edit_id').val(dId);
    $('#edit-name').val(name);
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
