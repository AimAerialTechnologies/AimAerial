<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

  <div class="h-100" data-simplebar>

    <!--- Sidemenu -->
    <div id="sidebar-menu">

      {{-- @if (strpos(Request::fullUrl(),'dashboard')) --}}
      @hasrole('Admin')
      <ul id="side-menu">
        <li class="menu-title mt-2">Drones</li>
        <li>
          <a href="{{route('drones.index')}}">
            <i data-feather="airplay"></i>
            <span> Drones list </span>
          </a>
        </li>

        <li class="menu-title mt-2">Organization</li>
        <li>
          <a href="{{route('company.index')}}">
            <i data-feather="activity"></i>
            <span> Companies </span>
          </a>
        </li>

        {{-- <li>
          <a href="{{route('data.index')}}">
            <i data-feather="unlock"></i>
            <span> Data Access </span>
          </a>
        </li> --}}

        <li class="menu-title mt-2">Users</li>

        <li>
          <a href="{{route('users.index')}}">
            <i data-feather="users"></i>
            <span> User List </span>
          </a>
        </li>


        <li class="menu-title mt-2">Permission</li>
        <li>
          <a href="{{route('tiers.index')}}">
            <i data-feather="cpu"></i>
            <span> Role </span>
          </a>
        </li>

      </ul>
      @endhasrole

        @hasrole('Regulator')
        <ul id="side-menu">
          @if (Auth::user()->hasPosition)
            @php
              $position = Auth::user()->hasPosition->position;
              $hasDatamenu = $position->hasDataMenu;
              if ($hasDatamenu) {
                $dataMenu_arr = explode(',',$hasDatamenu->datamenu);
              }
            @endphp
            @if(isset($dataMenu_arr))
              @if (in_array("Drone",$dataMenu_arr))
                <li class="menu-title mt-2">Drones</li>
                <li>
                  <a href="{{route('drones.index')}}">
                    <i data-feather="airplay"></i>
                    <span> Drones list</span>
                  </a>
                </li>
              @endif
              @if (in_array("Company",$dataMenu_arr))
                <li class="menu-title mt-2">Organization</li>
                <li>
                  <a href="{{route('company.user')}}">
                    <i data-feather="activity"></i>
                    Company
                  </a>
                </li>
              @endif
              @if (in_array("Position",$dataMenu_arr))
                <li>
                  <a href="{{route('position.index')}}">
                    <i data-feather="unlock"></i>
                    <span> Position </span>
                  </a>
                </li>
              @endif
              @if (in_array("User",$dataMenu_arr))
                <li class="menu-title mt-2">Users</li>
                <li>
                  <a href="{{route('users.index')}}">
                    <i data-feather="users"></i>
                    <span> User List </span>
                  </a>
                </li>
              @endif

            @else
              <li class="menu-title mt-2">Drones</li>
              <li>
                <a href="{{route('drones.index')}}">
                  <i data-feather="airplay"></i>
                  <span> Drones list</span>
                </a>
              </li>
              <li class="menu-title mt-2">Organization</li>
              <li>
                <a href="{{route('company.user')}}">
                  <i data-feather="activity"></i>
                  Company
                </a>
              </li>
              <li>
                <a href="{{route('position.index')}}">
                  <i data-feather="unlock"></i>
                  <span> Position </span>
                </a>
              </li>
              <li class="menu-title mt-2">Users</li>
              <li>
                <a href="{{route('users.index')}}">
                  <i data-feather="users"></i>
                  <span> User List </span>
                </a>
              </li>

            @endif
          @else

            <li class="menu-title mt-2">Drones</li>
            <li>
              <a href="{{route('drones.index')}}">
                <i data-feather="airplay"></i>
                <span> Drones list</span>
              </a>
            </li>
            <li class="menu-title mt-2">Organization</li>
            <li>
              <a href="{{route('company.user')}}">
                <i data-feather="activity"></i>
                Company
              </a>
            </li>
            <li>
              <a href="{{route('position.index')}}">
                <i data-feather="unlock"></i>
                <span> Position </span>
              </a>
            </li>
            <li class="menu-title mt-2">Users</li>
            <li>
              <a href="{{route('users.index')}}">
                <i data-feather="users"></i>
                <span> User List </span>
              </a>
            </li>
          @endif


        </ul>
        @endhasrole
      {{-- @endif --}}

      {{-- @if (strpos(Request::fullUrl(),'user-dash')) --}}
        @role('User')
        <ul id="side-menu">
            <li class="menu-title mt-2">menu</li>
            <li>
                <a href="{{route('drones.index')}}">
                    <i data-feather="airplay"></i>
                    <span> Drones </span>
                </a>
            </li>

            <li class="menu-title mt-2">Care Center</li>
            <li>
                <a href="{{ route('users.feedback') }}">
                    <i data-feather="rss"></i>
                    <span> Feedback Data </span>
                </a>
            </li>
            <li>
                <a href="{{ route('users.contact') }}">
                    <i data-feather="rss"></i>
                    <span> Contact Hotline </span>
                </a>
            </li>

        </ul>
        @endrole
      {{-- @endif --}}
    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>

  </div>
  <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
