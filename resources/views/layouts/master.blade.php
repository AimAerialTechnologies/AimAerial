<!DOCTYPE html>
<html lang="en">
    <head>

        @include('admin.commons.title-meta')


        @include('admin.commons.head-css')

    </head>

    <!-- body start -->
    <body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": false}'>

        <!-- Begin page -->
        <div id="wrapper">

    @include('admin.commons.topbar')

    @include('admin.commons.left-sidebar')

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
      <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

          <!-- start page title -->
          <div class="row">
            <div class="col-12">
              <div class="page-title-box">
                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                      @yield('breadcrumb')
                  </ol>
                </div>
                <h4 class="page-title"> @yield('title')</h4>
              </div>
            </div>
          </div>
          <!-- end page title -->
          @include('admin.commons.message')

          @yield('content')

        </div> <!-- container -->

      </div> <!-- content -->

      @include('admin.commons.footer')

    </div>

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


  </div>
  <!-- END wrapper -->

  @include('admin.commons.right-sidebar')

  <!-- Vendor js -->
  <script src="{{url('scripts/assets/js/vendor.min.js')}}"></script>

  <!-- Plugins js-->

  @yield('add-script')

  {{-- <script src="{{url('scripts/assets/libs/flatpickr/flatpickr.min.js')}}"></script>
  <script src="{{url('scripts/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

  <script src="{{url('scripts/assets/libs/selectize/js/standalone/selectize.min.js')}}"></script> --}}

  <!-- Dashboar 1 init js-->
  {{-- <script src="{{url('scripts/assets/js/pages/admin-1.init.js')}}"></script> --}}

  <!-- App js-->
  <script src="{{url('scripts/assets/js/app.min.js')}}"></script>

</body>
</html>
