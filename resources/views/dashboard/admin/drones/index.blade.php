@extends('layouts.master')

@section('title', Auth::user()->name."'s Dashboard" )


@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          @role ('Regulator')
          @if (auth()->user()->company)
            <h4 class="header-title">{{auth()->user()->company->name}}`s Drones List</h4>
          @endif
          @else
          <h4 class="header-title">Drones List</h4>
          @endrole
          <div class="col-sm-4">
            <a type="button" class="btn btn-primary rounded-pill waves-effect waves-light my-2" data-bs-toggle="modal" data-bs-target="#addModal"><i class="mdi mdi-plus"></i> Create Drone</a>
          </div>
          <div class="table-responsive">
            <table id="basic-datatable" class="table nowrap w-100">
              <thead>
                <tr>
                  @php
                  $titleArr = ['#' , 'Drone ID', 'Image', 'Drone Model' , 'Serial Number' , 'IMEI', 'Description', 'Owner', 'Status', 'Drone URL', 'Action'];
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
                @isset ($drones)
                  @foreach ($drones as $key => $drone)
                    <tr>
                      <td>{{ ++$n }}</td>
                      <td>{{Helper::hash($drone->id)}}</td>
                      <td><img src="{{ $drone->parse_image }}" width="50" height="50" /></td>
                      <td id="image-{{$n}}" class="d-none">{{$drone->parse_image}}</td>
                      <td id="model-{{$n}}">{{$drone->model}}</td>
                      <td id="serial_num-{{$n}}">{{$drone->serial_num}}</td>
                      <td id="imei-{{$n}}">{{$drone->imei}}</td>
                      <td id="description-{{$n}}">{{$drone->description}}</td>
                      <td id="owner-{{$n}}">
                        @if ($drone->user)
                          <a href="{{ route('users.show', ['user' => $drone->user->hashed_id]) }}">{{$drone->user->name}}</a>
                        @endif
                      </td>
                        @if ($drone->status == "Enable")
                        <td id="status-{{$n}}" class="text-success">{{$drone->status}}</td>
                        @elseif ($drone->status == "Disable")
                        <td id="status-{{$n}}" class="text-danger">{{$drone->status}}</td>
                        @endif
                      </td>
                      <td> <a href="{{route('drones.get',['id' => Helper::hash($drone->id,50)] )}}" target="_blank">Drone URL</a> </td>
                      <td>
                        <div class="dropdown btn-group dropstart mb-2">
                          <button class="btn btn-xs btn-light btn-outline-blue dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-list"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-center">
                            <button title="Show" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#viewModal" onclick="detailItem(this)" data-id="{{ $n }}"><i class="fe-eye"></i> View</button>
                            <button title="Update" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editItem(this)"
                                    data-id="{{ $n }}" data-did="{{ Helper::hash($drone->id) }}"><i class="mdi mdi-pencil"></i> Edit</button>
                            <button onclick="deleteItem(this)" title="Delete" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-del-title="{{$drone->model}}" data-keyid="{{Helper::hash($drone->id)}}"><i class="fe-trash-2"></i> Delete</button>
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
          <h4 class="modal-title text-white">Drone Details</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group row">
              <label for="detail-model" class="col-sm-2 col-form-label">Model Image</label>
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
            Drone User
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{route('drones.store')}}" enctype="multipart/form-data" >
            @csrf
            <div class="mb-3 col-12">
              <label for="file" class="form-label">Upload Image Here</label>
              <input class="form-control" type="file" name="image" id="image" accept="image/jpeg,image/png" required>
              <small><i>Size limit 5mb. Image format must be in .png or .jpeg</i></small>
            </div>
            <div class="mb-3 col-12">
              <label for="name" class="form-label">Model Name</label>
              <input class="form-control" type="text" name="model" id="model" required>
            </div>
            <div class="mb-3 col-12">
              <label for="email">Serial Number</label>
              <input type="text" class="form-control" id="serial_num" name="serial_num" required>
            </div>
            <div class="mb-3 col-12">
              <label for="ic">IMEI</label>
              <input type="text" class="form-control" id="imei" name="imei" required>
            </div>
            <div class="mb-3 form-group">
              <label for="Description">Description</label>
              <textarea class="form-control" id="description" name="description" rows="2"></textarea>
            </div>
            <div class="mb-3 form-group">
              <label for="Status">Status</label>
              <div class="form-check col-3">
                <input class="form-check-input" type="radio" name="status" id="enable" value="Enable"/>
                <label class="form-check-label" for="enable">
                  Enable
                </label>
              </div>
              <div class="form-check col-3">
                <input class="form-check-input" type="radio" name="status" id="disable" value="Disable"/>
                <label class="form-check-label" for="disable">
                  Disable
                </label>
              </div>
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

<!--Edit Modal Start-->
<div class="modal fade" id="editModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header bg-primary">
        <h4 class="modal-title text-white">
          Drone User
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('drones.edit')}}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" id="edit_id" name="edit_id">
          <div class="mb-3 col-12">
            <label for="file" class="form-label">Upload Image Here</label>
            <input class="form-control" type="file" name="image" id="edit-image" accept="image/jpeg,image/png">
            <small><i>Size limit 5mb. Image format must be in .png or .jpeg</i></small>
          </div>
          <div class="mb-3 col-12">
            <label for="model" class="form-label">Model Name</label>
            <input class="form-control" type="text" name="model" id="edit-model">
          </div>
          <div class="mb-3 col-12">
            <label for="serial_num">Serial Number</label>
            <input type="text" class="form-control" id="edit-serial_num" name="serial_num">
          </div>
          <div class="mb-3 col-12">
            <label for="imei">IMEI</label>
            <input type="text" class="form-control" id="edit-imei" name="imei">
          </div>
          <div class="mb-3 form-group">
            <label for="Description">Description</label>
            <textarea class="form-control" id="edit-description" name="description" rows="2"></textarea>
          </div>
          <div class="mb-3 form-group">
            <label for="Status">Status</label>
            <div class="form-check col-3">
              <input class="form-check-input" type="radio" name="status" id="edit-enable" value="Enable"/>
              <label class="form-check-label" for="edit-enable">
                Enable
              </label>
            </div>
            <div class="form-check col-3">
              <input class="form-check-input" type="radio" name="status" id="edit-disable" value="Disable" />
              <label class="form-check-label" for="edit-disable">
                Disable
              </label>
            </div>
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
      <form method="POST" action="{{route('drones.destroy')}}">
        @csrf
        <div class="modal-header text-uppercase bg-light">
          <h5 class="modal-title">Delete Drone</h5>
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
  <script type="text/javascript">

    // View Details
    function detailItem(d) {
    var keyID = d.getAttribute("data-id");
    var image = $('#image-'+keyID).text();
    var model = $('#model-'+keyID).text();
    var serial_num = $('#serial_num-'+keyID).text();
    var imei = $('#imei-'+keyID).text();
    var description = $('#description-'+keyID).text();
    var owner = $('#owner-'+keyID).text();
    var status = $('#status-'+keyID).text();
    $('#detail-model').text(model);
    $('#detail-serial_num').text(serial_num);
    $('#detail-imei').text(imei);
    $('#detail-description').text(description);
    $('#detail-status').text(status);
    $('#detail-owner').text(owner);
    $('#detail-image').attr('src', image);

  }

    //edit Details
    function editItem(d) {
    var keyID = d.getAttribute("data-id");
    var dId = d.getAttribute("data-did");
    var model = $('#model-'+keyID).text();
    var serial_num = $('#serial_num-'+keyID).text();
    var imei = $('#imei-'+keyID).text();
    var description = $('#description-'+keyID).text();
    var status = $('#status-'+keyID).text();
    $('#edit_id').val(dId);
    $('#edit-model').val(model);
    $('#edit-serial_num').val(serial_num);
    $('#edit-imei').val(imei);
    $('#edit-description').val(description);
    if (status=="Disable") {
      $("#edit-enable").prop("checked", false);
      $("#edit-disable").prop("checked", true);
    }
    else if (status=="Enable") {
      $("#edit-disable").prop("checked", false);
      $("#edit-enable").prop("checked", true);
    }
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
