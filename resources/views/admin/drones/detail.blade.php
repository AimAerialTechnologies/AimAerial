@extends('layouts.drone')

@section('title', 'Drone Details' )

@section('content')
  <div class="card" style="height:100vh !important; margin-bottom:0px !important; ">
    <div class="card-body text-center">
      <h3 class="header-title">Drone Details</h3>
      <table>
        <div class="row text-center">
          <div class="col-12">
            @isset($drones)
              <div class="border border-5" style="height:90vh; position:relative;">

                @if(Auth::id())

                  @if(Auth::user()->hasRole('Admin'))
                    <img src="{{Helper::parseUrl($drones->image)}}" alt="drone_image" class="m-1 p-2" width="250" height="250" >
                    <br>
                    <p>ID : <b>{{$drones->hashedId}}</b></p>
                    <p>Model Name : <b>{{$drones->model}}</b></p>
                    <p>IMEI : <b>{{$drones->imei}}</b></p>
                    <p>S/N : <b>{{$drones->serial_num}}</b></p>
                    <p>Description : <b>{{$drones->description}}</b></p>
                    <p>Status : <b>{{$drones->status}}</b></p>
                    <p>Owner : <b>{{$drones->user->name}}</b></p>
                    <p><a href="{{route('drones.qr',['id' => Helper::hash($drones->id,50)] )}}" target="_blank">QR Code</a></p>
                  @elseif (Auth::user()->hasRole('Regulator'))
                    @if (Auth::user()->hasPosition)
                      @php
                        $position = Auth::user()->hasPosition->position;
                        $hasDataaccess = $position->dataaccess;
                        if ($hasDataaccess) {
                          $dataAccess_arr = explode(',',$hasDataaccess->dataaccess);
                        }
                      @endphp
                      @isset($dataAccess_arr)
                        @if (in_array("Image",$dataAccess_arr))
                          <img src="{{Helper::parseUrl($drones->image)}}" alt="drone_image" class="m-1 p-2" width="250" height="250" >
                          <br>
                        @endif
                        @if (in_array("Drone ID",$dataAccess_arr))
                          <p>ID : <b>{{$drones->hashedId}}</b></p>
                        @endif
                        @if (in_array("Drone Model",$dataAccess_arr))
                          <p>Model Name : <b>{{$drones->model}}</b></p>
                        @endif
                        @if (in_array("Serial Number",$dataAccess_arr))
                          <p>S/N : <b>{{$drones->serial_num}}</b></p>
                        @endif
                        @if (in_array("IMEI",$dataAccess_arr))
                          <p>IMEI : <b>{{$drones->imei}}</b></p>
                        @endif
                        @if (in_array("Description",$dataAccess_arr))
                          <p>Description : <b>{{$drones->description}}</b></p>
                        @endif
                        @if (in_array("Owner",$dataAccess_arr))
                          <p>Owner : <b>{{$drones->user->name}}</b></p>
                        @endif
                        @if (in_array("Status",$dataAccess_arr))
                          <p>Status : <b>{{$drones->status}}</b></p>
                        @endif
                        @if (in_array("QR Code",$dataAccess_arr))
                          <p><a href="{{route('drones.qr',['id' => Helper::hash($drones->id,50)] )}}" target="_blank">QR Code</a></p>
                        @endif
                      @endisset
                      {{-- {{ $hasDataaccess->dataaccess}} --}}
                    @endif
                  @elseif (Auth::user()->hasRole('User'))
                    <img src="{{Helper::parseUrl($drones->image)}}" alt="drone_image" class="m-1 p-2" width="250" height="250" >
                    <br>
                    <p>Model Name : <b>{{$drones->model}}</b></p>
                    <p>IMEI : <b>{{$drones->imei}}</b></p>
                    <p>S/N : <b>{{$drones->serial_num}}</b></p>
                  @endif
                  @else
                    <img src="{{Helper::parseUrl($drones->image)}}" alt="drone_image" class="m-1 p-2" width="250" height="250" >
                    <br>
                    <p>Model Name : <b>{{$drones->model}}</b></p>
                    <p>IMEI : <b>{{$drones->imei}}</b></p>
                    <p>S/N : <b>{{$drones->serial_num}}</b></p>
                    <br>
                    <span class="fst-italic" style="position: absolute;bottom: 10px;left: 0;right: 0;">To view more please <a href="{{route('login') }}">login</a> or <a href="{{route('register') }}">register</a>.</span>
                @endif
                {{-- <p>QR Code : <br>{{QrCode::size(300)->backgroundColor(255,90,0)->generate(route('drones.get',['id' => Helper::hash($drones->id,50)] )) }}</p> --}}
              </div>

            </div>
          @endisset
        </div>
      </div>
    </table>
  </div>

@endsection

@section('add-css')
<style media="screen">
  .account-pages
  {
    margin-top:0px !important;
    margin-bottom: 0px !important;
  }
</style>
@endsection
