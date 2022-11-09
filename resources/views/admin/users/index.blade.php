@extends('layouts.master')

@section('title', "All Users" )

@section('breadcrumb')
  <li class="breadcrumb-item">
    <a href="{{ route('dashboard') }}">
    Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Users List</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="header-title">Users List</h4>
          <div class="col-sm-4 mb-2">
            <button type="button" class="btn btn-primary rounded-pill waves-effect waves-light my-2" data-bs-toggle="modal" data-bs-target="#addModal">
              <i class="mdi mdi-plus"></i>
              Create New User
            </button>
          </div>
          <div class="table-responsive">
            <table id="basic-datatable" class="table nowrap w-100">
              <thead>
                <tr>
                  @php
                  $titleArr = ['#' , 'User ID' , 'User Name' , 'I/C' , 'Email', 'Company', 'Role' , 'Position', 'Action'];
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
                @isset ($users)
                  @foreach ($users as $key => $user)
                    <tr>
                      <td>{{ ++$n }}</td>
                      <td>{{Helper::hash($user->id)}}</td>
                      <td id="name-{{$n}}">{{$user->name}}</td>
                      <td id="ic-{{$n}}">{{$user->ic}}</td>
                      <td id="email-{{$n}}">{{$user->email}}</td>
                      <td id="company-{{$n}}">
                        @if ($user->company)
                        {{$user->company->name}}
                        <p id="companyHash-{{$n}}" hidden>{{$user->company->hashed_id}}</p>
                        @endif
                      </td>
                      <td>
                        @if ($user->role($user->id) == "Admin")
                          <span class="badge bg-primary">Admin</span>
                          <p id="roleHash-{{$n}}" hidden>{{$user->role($user->id)}}<p>
                          @elseif ($user->role($user->id) == "User")
                          <span class="badge bg-success">User</span>
                          <p id="roleHash-{{$n}}" hidden>{{$user->role($user->id)}}<p>
                        @elseif ($user->role($user->id) == "Regulator")
                          <span class="badge bg-info">Regulator</span>
                          <p id="roleHash-{{$n}}" hidden>{{$user->role($user->id)}}<p>
                        @else
                          <span class="badge bg-danger">To be Assigned</span>
                        @endif
                      </td>

                      @if ($user->hasPosition)
                        <td id="position-{{$n}}">{{$user->hasPosition->position->name}}</td>
                        <p id="positionHash-{{$n}}" hidden>{{$user->hasPosition->position->hashed_id}}</p>
                        @else
                          <td id="position-{{$n}}">Not Assigned</td>
                      @endif
                      <td>
                        <div class="dropdown btn-group dropstart">
                          <button class="btn btn-xs btn-light btn-outline-blue dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-list"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-center">
                            <button title="Show" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#viewModal" onclick="detailItem(this)" data-id="{{ $n }}"><i class="fe-eye"></i> View</button>
                            {{-- <a href="{{ route('users.show',
                            ['user' => Helper::hash($user->id)]) }}" title="View" class="dropdown-item"><i class="fe-eye"></i> View</a> --}}
                            <button title="Edit" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editItem(this)"
                                    data-id="{{ $n }}" data-did="{{ Helper::hash($user->id) }}"><i class="mdi mdi-pencil"></i> Edit</button>
                            <button onclick="deleteItem(this)" title="Delete" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-del-title="{{$user->name}}" data-keyid="{{Helper::hash($user->id)}}"><i class="fe-trash-2"></i> Delete</button>
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
        <h4 class="modal-title text-white">User Details</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group row">
            <label for="detail-name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-6">
              <p id="detail-name" class="col-form-label">Name</p>
            </div>
          </div>
          <div class="form-group row">
            <label for="detail-email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-6">
              <p id="detail-email" class="col-form-label">Email</p>
            </div>
          </div>
          <div class="form-group row">
            <label for="detail-ic" class="col-sm-2 col-form-label">I/C</label>
            <div class="col-sm-6">
              <p id="detail-ic" class="col-form-label">I/C</p>
            </div>
          </div>
          <div class="form-group row">
            <label for="detail-company" class="col-sm-2 col-form-label">Company</label>
            <div class="col-sm-6">
              <p id="detail-company" class="col-form-label">Company</p>
            </div>
          </div>
          <div class="form-group row">
            <label for="detail-role" class="col-sm-2 col-form-label">Role</label>
            <div class="col-sm-6">
              <p id="detail-role" class="col-form-label">Role</p>
            </div>
          </div>
          <div class="form-group row">
            <label for="detail-position" class="col-sm-2 col-form-label">Position</label>
            <div class="col-sm-6">
              <p id="detail-position" class="col-form-label">Position</p>
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
            Add User
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{route('users.store')}}">
            @csrf
            <div class="mb-3 col-12">
              <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="name" id="name" required>
            </div>
            <div class="mb-3 col-12">
              <label for="email">Email <span class="text-danger">*</span></label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3 col-12">
              <label for="password">Password <span class="text-danger">*</span></label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3 col-12">
              <label for="ic">I/C <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="ic" name="ic" required>
            </div>
            <div class="mb-3 col-12 @role('Regulator') d-none @endrole">
              <label for="company">Company <span class="text-danger">*</span>
                @role('Admin')
                <br>
                <small><a href="{{ route('company.index') }}">Add Company</a></small>
                @endrole
              </label>
              <select name="company" class="form-control @role('Regulator') d-none @endrole" id="company">
                <option value="">Select Company</option>
                @foreach ($companies as $key => $company)
                  <option value="{{ $company->hashed_id }}" @role('Regulator')selected @endrole>{{ $company->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3 col-12">
              <label for="role">Role <span class="text-danger">*</span></label>
              <select name="role" class="form-control" id="role" required>
                <option value="">Select Role</option>
                @foreach ($roles as $key => $role)
                  @if ($role->name != "Admin")
                    <option>{{ $role->name }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            {{-- @role('Regulator') --}}
            <div class="mb-3 col-12">
              <label for="position">Position <span class="text-danger">*</label>
              <select name="position" class="form-control" id="position" required>
                <option value="">Select Position</option>
                @foreach ($positions as $key => $position)
                  <option value="{{ $position->hashed_id }}" >{{ $position->name }}</option>
                @endforeach
              </select>
            </div>
            {{-- @endrole --}}
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


{{-- Edit Modal begin --}}
<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title text-white">Edit Details</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('users.edit') }}" method="POST">
            @csrf
            <input type="hidden" id="edit-id" name="edit_id">
            <div class="mb-3 col-12">
              <label for="edit-name" class="form-label">Name</label>
              <input class="form-control" type="text" name="name" id="edit-name">
            </div>
            <div class="mb-3 col-12">
              <label for="edit-email">Email</label>
              <input type="email" name="email" class="form-control" id="edit-email">
            </div>
            <div class="mb-3 col-12">
              <label for="edit-ic">I/C</label>
              <input type="text" name="ic" class="form-control" id="edit-ic">
            </div>
            <div class="mb-3 col-12">
              <label for="company">Company
                @role('Admin')
                <small><a href="{{ route('company.index') }}">Add Company</a></small>
                @endrole
              </label>
              <select id="edit-company" name="company" class="form-control">
                @foreach ($companies as $key => $company)
                  <option value="{{ $company->hashed_id }}" {{ $company->hashed_id==$user->company_id ? 'selected' : ''}}>{{ $company->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3 col-12">
              <label for="role">Role</label>
              <select name="role" class="form-control" id="edit-role" class="form-control" required>
                @foreach ($roles as $key => $role)
                  <option>{{ $role->name }}</option>
                @endforeach
              </select>
            </div>
            {{-- @role('Regulator') --}}
            <div class="mb-3 col-12">
              <label for="edit-position">Position</label>
              <select name="position" class="form-control" id="edit-position" required>
                @foreach ($positions as $key => $position)
                  <option value="{{ $position->hashed_id }}" {{ $position->hashed_id==$user->company_id ? 'selected' : ''}}>{{ $position->name }}</option>
                @endforeach
              </select>
            </div>
            {{-- @endrole --}}
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary edit_user">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  {{-- Edit Modal end --}}

{{-- Delete Modal begin --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-dark-theme">
      <form method="POST" action="{{route('users.destroy')}}">
        @csrf
        <div class="modal-header text-uppercase bg-light">
          <h5 class="modal-title">Delete Screen</h5>
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
  title: 'Brochure'
  },
  {
  extend: "csv",
  className: "btn btn-light btn-xs",
  exportOptions: { columns: 'th:not(:last-child)' },
  title: 'Brochure'
  },
  {
  extend: "excel",
  className: "btn btn-light btn-xs",
  exportOptions: { columns: 'th:not(:last-child)' },
  title: 'Brochure'
  },
  {
  extend: "print",
  className: "btn btn-light btn-xs",
  exportOptions: { columns: 'th:not(:last-child)' },
  title: 'Brochure'
  }, {
  extend: "pdf",
  className: "btn btn-light btn-xs",
  exportOptions: { columns: 'th:not(:last-child)' },
  title: 'Brochure'
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
//show Users Data
function detailItem(d) {
  var keyID = d.getAttribute("data-id");
  var name = $('#name-'+keyID).text();
  var ic = $('#ic-'+keyID).text();
  var company = $('#company-'+keyID).text();
  var email = $('#email-'+keyID).text();
  var role = $('#role-'+keyID).text();
  var roleHash = $('#roleHash-'+keyID).text();
  var position = $('#position-'+keyID).text();
  $('#detail-name').text(name);
  $('#detail-ic').text(ic);
  $('#detail-email').text(email);
  $('#detail-company').text(company);
  $('#detail-role').text(roleHash);
  $('#detail-position').text(position);
}

//Edit Users Data
function editItem(d) {
  var keyID = d.getAttribute("data-id");
  var dId = d.getAttribute("data-did");
  var name = $('#name-'+keyID).text();
  var ic = $('#ic-'+keyID).text();
  var email = $('#email-'+keyID).text();
  var company = $('#company-'+keyID).text();
  var companyHash = $('#companyHash-'+keyID).text();
  var role = $('#role-'+keyID).text();
  var roleHash = $('#roleHash-'+keyID).text();
  var positionHash = $('#positionHash-'+keyID).text();
  $('#edit-id').val(dId);
  $('#edit-name').val(name);
  $('#edit-ic').val(ic);
  $('#edit-email').val(email);
  $('#edit-company').val(companyHash);
  $('#edit-role').val(roleHash);
  $('#edit-position').val(positionHash);
}

//Delete Users Data
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
