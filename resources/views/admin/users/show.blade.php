@extends('layouts.master')

@section('title', $user->name."`s Details" )

@section('breadcrumb')
  <li class="breadcrumb-item">
    <a href="{{route('users.index')}}">
    All User</a>
  </li>
  <li class="breadcrumb-item active">{{$user->name}}`s Details</li>
@endsection

@section('content')

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="form-group row">
            <label for="detail-name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-6">
              <p id="detail-name" class="col-form-label">{{$user->name}}</p>
            </div>
          </div>
          <div class="form-group row">
            <label for="detail-email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-6">
              <p id="detail-email" class="col-form-label">{{$user->email}}</p>
            </div>
          </div>
          <div class="form-group row">
            <label for="detail-ic" class="col-sm-2 col-form-label">I/C</label>
            <div class="col-sm-6">
              <p id="detail-ic" class="col-form-label">{{$user->ic}}</p>
            </div>
          </div>
          <div class="form-group row">
            <label for="detail-ic" class="col-sm-2 col-form-label">Company</label>
            <div class="col-sm-6">
              <p id="detail-ic" class="col-form-label">{{$user->company->name}}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
