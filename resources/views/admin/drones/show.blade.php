@extends('layouts.master')

@section('title', "Drones Detail" )

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body text-center">
          <h3 class="header-title">Drones Detail</h3>
          <table>
            <div class="row text-center">
                <div class="col-12">
                  @isset($drones)
                  <div class="border border-5">
                    <img src="{{Helper::parseUrl($drones->image)}}" alt="drone_image" class="m-3" width="50" height="50">
                    <br>
                    <a href="{{Helper::parseUrl($drones->image)}}">{{Helper::parseUrl($drones->image)}}</a>
                    <p>Model Name : <b>{{$drones->model}}</b></p>
                    <p>IMEI : <b>{{$drones->imei}}</b></p>
                    <p>S/N : <b>{{$drones->serial_num}}</b></p>
                  @endisset
                </div>
            </div>

          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
