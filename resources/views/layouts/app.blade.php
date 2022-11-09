<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Admin Dashboard') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- UBold Scripts -->

        <!-- Plugins css -->
        <link href="../scripts/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
        <link href="../scripts/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link href="{{ url('assets/css/config/default/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
        <link href="{{ url('assets/css/config/default/app.min.css') }}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

        <link href="{{ url('assets/css/config/default/bootstrap-dark.min.css') }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
        <link href="{{ url('assets/css/config/default/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

        <!-- icons -->
        <link href="{{ url('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": false}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": false}'>

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                <div id="wrapper">
                {{ $slot }}
                </div>
            </main>
        </div>

        @stack('modals')

        @livewireScripts

        <!-- Vendor js -->
        <script src="../scripts/assets/js/vendor.min.js"></script>

        <!-- Plugins js-->
        <script src="../scripts/assets/libs/flatpickr/flatpickr.min.js"></script>
        <script src="../scripts/assets/libs/apexcharts/apexcharts.min.js"></script>

        <script src="../scripts/assets/libs/selectize/js/standalone/selectize.min.js"></script>

        <!-- Dashboar 1 init js-->
        <script src="../scripts/assets/js/pages/dashboard-1.init.js"></script>

        <!-- App js-->
        <script src="../scripts/assets/js/app.min.js"></script>
    </body>
</html>
