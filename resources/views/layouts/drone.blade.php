<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title> @yield('title') | {{ config('app.name', 'Laravel') }}</title>
  {{-- <title>@yield('title') </title> --}}
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Layered User Interface Interface System for Drone and Aero Services" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  {{-- <link rel="shortcut icon" href="{{ url('assets/images/merdeka-award.jpg') }}"> --}}


  <!-- App css -->
  <link href="{{ url('scripts/assets/css/config/default/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
  <link href="{{ url('scripts/assets/css/config/default/app.min.css') }}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

  <!-- icons -->
  <link href="{{ url('scripts/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
  <style>
  @media screen and (max-width: 600px){
    body{
      height:100%;
      width:100%;
    }
  }
  </style>
  @yield('add-css')
</head>
<body>
    {{-- style="background-image: url({{url('assets/images/main-bg.jpg')}});height: 100vh;position: fixed;width: 100%;overflow-y: auto;background-size:100% 100%; background-repeat:no-repeat;" --}}
  <div class="account-pages mt-2 mb-2">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-8">

          @yield('content')

        </div> <!-- end col -->
      </div>
      <!-- end row -->
    </div>
    <!-- end container -->
  </div>
  <!-- end page -->


  <!-- Vendor js -->
  <script src="{{ url('scripts/assets/js/vendor.min.js') }}"></script>
  @yield('add-script')

  <!-- App js -->
  <script src="{{ url('scripts/assets/js/app.min.js') }}"></script>

</body>
</html>
