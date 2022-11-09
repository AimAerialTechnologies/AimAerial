@extends('layouts.master')

@section('title', "Roles")

@section('breadcrumb')
  <li class="breadcrumb-item">
    <a href="{{ route('dashboard') }}">
    Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Role List</li>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="header-title">User's Role</h4>
          <p class="sub-header">Assign User tier list below in the action section</p>
          <div class="table-responsive">
            <table id="basic-datatable" class="table nowrap w-100">
              <thead>
                <tr>
                  @php
                  $titleArr = ['#', 'User Role', 'Total User','Action'];
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
                @isset ($roles)
                  @foreach ($roles as $key => $role)
                    <tr>
                      <td>{{ ++$n }}</td>
                      <td id="name-{{$n}}">{{$role->name}}</td>
                      <td>{{$role->CountUser}}</td>
                      <td>
                        <div class="dropdown btn-group dropstart">
                          <button class="btn btn-xs btn-light btn-outline-blue dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-list"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-center">
                            <a href="{{ route('tiers.show',
                            ['tier' => $role->HashedId]) }}" title="View" class="dropdown-item"><i class="fe-eye"></i> View</a>
                            <button title="Edit" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editItem(this)" data-id="{{ $n }}" data-did="{{ $role->name }}"><i class="mdi mdi-pencil"></i> Edit</button>
                            <button onclick="deleteRoom(this)" title="Delete" class="dropdown-item text-danger" data-del-room-title="{{--$data->room_name--}}" data-keyid="{{--Helper::hash($data->id)--}}"><i class="fe-trash-2"></i> Delete</button>
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


{{-- Edit Modal begin --}}
<div class="modal fade" id="editModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h4 class="modal-title text-white">Edit Details</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('tiers.updateRole') }}" method="POST">
          @csrf
          <input type="hidden" id="edit-id" name="edit_id">
          <div class="mb-3 col-12">
            <label for="edit-name" class="form-label">Tier Name</label>
            <input class="form-control" type="text" name="name" id="edit-name">
          </div>

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
@endsection

@section('add-css')
<script type="text/javascript">

function editItem(d) {
  var keyID = d.getAttribute("data-id");
  var dId = d.getAttribute("data-did");
  var name = $('#name-'+keyID).text();
  $('#edit-id').val(dId);
  $('#edit-name').val(name);
}
</script>
@endsection
