@extends('layouts.master')

@section('title', "Roles")

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="header-title">User's Role</h4>
          <p class="sub-header">Assign User role list below in the action section</p>
          <div class="table-responsive">
            <table id="basic-datatable" class="table nowrap w-100">
              <thead>
                <tr>
                  @php
                  $titleArr = ['#' , 'User name' , 'User role', 'Action'];
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
                      <td>{{$user->getRoleNames()[0] ?? 'No role' }}</td>
                      <td>
                        <div class="dropdown btn-group dropstart">
                          <button class="btn btn-xs btn-light btn-outline-blue dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-list"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-center">
                            <a href="{{ route('roles.show',
                            ['role' => Helper::hash($user->id)]) }}" title="View" class="dropdown-item"><i class="fe-eye"></i> View</a>
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

@endsection
