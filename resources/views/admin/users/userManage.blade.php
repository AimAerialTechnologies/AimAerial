@extends('layouts.master')

@section('title', Auth::user()->name."'s Dashboard" )


@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="header-title">User Role</h4>
          <p class="sub-header">Select User to update roles</p>
          <div class="table-responsive">

          <table id="basic-datatable" class="table dt-responsive nowrap w-100">
            <thead>
              <tr>
                @php
                $titleArr = ['#' , 'User Name' , 'User Role' , 'Action'];
                @endphp
                @foreach ($titleArr as $key => $value)
                  <th>{{$value}}</th>
                @endforeach
              </tr>
            </thead>
          <tbody>
            {{-- @php
            $n = 1;
            @endphp
            @if ($roles)
              @foreach ($roles as $role)
                <tr>
                  <td>{{ $n++ }}</td>
                  <td>{{ $role->name }}</td>
                  <td>{{ $role->display_name }}</td>
                  <td>
                    @if ($role->name!="superadmin" && $role->name!="admin" || $isAdmin)
                        <a href="{{ route('backend.user.role.edit', Helper::hash($role->id)) }}" class="btn btn-xs btn-light"><i class="fe-edit-1"></i></a>
                        @if ($role->name!="superadmin" && $role->name!="admin")

                        <button onclick="deleteKey(this)" class="btn btn-xs btn-danger deleteKey" data-del-role-title="{{$role->display_name}}" data-keyid="{{Helper::hash($role->id)}}"><i class="fe-trash-2"></i></button>
                      @endif
                    @endif
                  </td>

                </tr>
              @endforeach
            @endif --}}
          </tbody>
        </table>
        </div>
          </div>
      </div>
    </div>
  </div>

@endsection
