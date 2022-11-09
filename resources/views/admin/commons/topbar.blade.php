<!-- Topbar Start -->
<div class="navbar-custom">
  <div class="container-fluid">
    <ul class="list-unstyled topnav-menu float-end mb-0">


      <li class="dropdown notification-list topbar-dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          {{ Auth::user()->name }}
          <i class="mdi mdi-chevron-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
          <x-slot name="content">

            <a href="{{ route('profile.show') }}" class="dropdown-item notify-item">
              <i class="fe-user"></i>
              <span>My Profile</span>
            </a>

            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
              <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                {{ __('API Tokens') }}
              </x-jet-dropdown-link>
            @endif

            <div class="dropdown-divider"></div>


            <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            <i class="fe-log-out"></i>
            {{ __('Logout') }}
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>

        </li>

        @if (auth()->user()->hasRole('Admin'))
          <li class="dropdown notification-list">
            <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
              <i class="fe-settings noti-icon"></i>
            </a>
          </li>
        @endif

      </ul>

      <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
          <button class="button-menu-mobile waves-effect waves-light">
            <i class="fe-menu"></i>
          </button>
        </li>

        <li class="dropdown d-none d-xl-block">
          <a class="nav-link dropdown-toggle waves-effect waves-light" href="{{ route('welcome') }}" role="button" aria-haspopup="false" aria-expanded="false">
            Main Page
          </a>
        </li>

        {{-- @if (!strpos(Request::fullUrl(),'dashboard'))
          <li class="dropdown d-none d-xl-block">
            <a class="nav-link dropdown-toggle waves-effect waves-light" href="{{ route('dashboard') }}" role="button" aria-haspopup="false" aria-expanded="false">
              Admin Dashboard
            </a>
          </li>
        @endif

        @if (!strpos(Request::fullUrl(),'user-dash'))
          <li class="dropdown d-none d-xl-block">
            <a class="nav-link dropdown-toggle waves-effect waves-light" href="{{ route('user-dashboard') }}" role="button" aria-haspopup="false" aria-expanded="false">
              User Dashboard
            </a>
          </li>
        @endif

        @if (!strpos(Request::fullUrl(),'regulator-dash'))
          <li class="dropdown d-none d-xl-block">
            <a class="nav-link dropdown-toggle waves-effect waves-light" href="{{ route('regulator-dashboard') }}" role="button" aria-haspopup="false" aria-expanded="false">
              Regulator Dashboard
            </a>
          </li>
        @endif --}}

        <li>
          <!-- Mobile menu toggle (Horizontal Layout)-->
          <a class="navbar-toggle nav-link" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
            <div class="lines">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </a>
          <!-- End mobile menu toggle-->
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
  </div>
  <!-- end Topbar -->
