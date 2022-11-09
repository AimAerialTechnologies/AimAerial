@extends('layouts.master')

@section('title', Auth::user()->name."'s Dashboard" )


@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="header-title">Select Any of the options on the left to view functions</h4>
          {{-- <div class="table-responsive">
            <table id="basic-datatable" class="table nowrap w-100">
              <thead>
                <tr>
                  @php
                  $titleArr = ['#' , 'Name' , 'Student ID' , 'Phone Number' , 'Email', 'Covid Result' , 'Action'];
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
                      <td>{{$user->name}}</td>
                      <td>{{$user->student_id}}</td>
                      <td>{{$user->contact}}</td>
                      <td>{{$user->email}}</td>
                      @if ($user->profile->c_status=="negative")
                        <td><span class="badge bg-success">Negative</span></td>
                      @elseif ($user->profile->c_status=="positive")
                        <td><span class="badge bg-danger">Positive</span></td>
                      @else
                        <td><span class="badge bg-warning">Incomplete</span></td>
                      @endif
                      <td class="text-center">
                        <div class="dropdown btn-group dropstart">
                          <button class="btn btn-xs btn-light btn-outline-blue dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-list"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-center">
                            <a href="{{ route('admin.student.details',
                            ['id' => Helper::hash($user->id)]) }}" title="View" class="dropdown-item"><i class="fe-eye"></i> View</a>
                            <button onclick="deleteRoom(this)" title="Delete" class="dropdown-item text-danger" data-del-room-title="$data->room_name" data-keyid="Helper::hash($data->id)"><i class="fe-trash-2"></i> Delete</button>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                @endisset
              </tbody>
            </table> --}}

          </div>
        </div> <!-- end card-body -->
      </div> <!-- end card -->
    </div><!-- end col -->
  </div><!-- end row -->

  <div class="modal fade" id="deleteRoomModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content modal-dark-theme">
        <form action="#" method="POST">
          <div class="modal-header text-uppercase bg-light">
            <h5 class="modal-title">Delete Screen</h5>
            <button type="button" class="close close-red" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p id="del_msg"></p>
            <input type="hidden" name="delete_id" id="delete_id">
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Confirm</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection


@section('add-css')
  {{-- <link href="{{ url('assets/libs/bootstrap-table/bootstrap-table.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ url('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ url('assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ url('assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ url('assets/libs/datatables.net-select-bs5/css//select.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" /> --}}
@endsection

@section('add-script')
  {{-- <script src="{{ url('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ url('assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
  <script src="{{ url('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ url('assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
  <script src="{{ url('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ url('assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
  <script src="{{ url('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
  <script src="{{ url('assets/libs/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
  <script src="{{ url('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
  <script src="{{ url('assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
  <script src="{{ url('assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>
  <script src="{{ url('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
  <script src="{{ url('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script> --}}

  {{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> --}}
  {{-- <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css"> --}}
  <!-- third party js ends -->

  <!-- Start Download Files -->
  {{-- <script type="text/javascript" >

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
title: 'Brochure'
},
{
extend: "csv",
className: "btn btn-light btn-xs",
title: 'Brochure'
},
{
extend: "excel",
className: "btn btn-light btn-xs",
title: 'Brochure'
},
{
extend: "print",
className: "btn btn-light btn-xs",
title: 'Brochure'
}, {
extend: "pdf",
className: "btn btn-light btn-xs",
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

function deleteRoom(d) {
  var keyID = d.getAttribute("data-keyid");
  var keyTitle = d.getAttribute("data-del-screen-title");
  var shwMsg = document.getElementById("del_msg");
  shwMsg.innerHTML = "Are you sure you wish to delete <strong>"+keyTitle+"</strong>?";
  $('#delete_id').val(keyID);
  $('#deleteRoomModal').modal('show');
}
</script> --}}
<!-- End Download Files -->
<!-- Datatables init -->
{{-- <script src="{{ url('assets/js/pages/datatables.init.js') }}"></script> --}}
@endsection
