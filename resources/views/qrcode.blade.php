@extends('layouts.master')

@section('title', Auth::user()->name."'s Dashboard" )


@section('content')
    <div class="card">
      <div class="card-header text-center">
          {{-- <h3>Scan Here to go to our website</h3> --}}
      </div>
      <div class="card-body card-body justify-content-center align-items-center text-center">
          {!! QrCode::size(500)->generate('http://167.71.195.225')!!}
    </div>
    </div>
@endsection
