<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">@lang('translation.Menu')</li>

                <li>
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">@lang('translation.Dashboard')</span>
                    </a>
                    
                </li>

                <li>
                    <a href="{{ route('admin.map.analytics') }}" class="waves-effect">
                        <i class="bx bx-map-alt"></i>
                        <span key="t-maps">@lang('translation.Map')</span>
                    </a>
                    
                </li>


                <li>
                    <a href="{{route('users.index')}}" class="waves-effect">
                        <i class="bx bx-user"></i>
                        <span key="t-users">@lang('translation.Users')</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('devices.index') }}" class="waves-effect">
                        <i class="bx bx-cycling"></i>
                        <span key="t-devices">@lang('translation.Devices')</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.reports.index') }}" class="waves-effect">
                        <i class="bx bx-notepad"></i>
                        <span key="t-reports">@lang('translation.Reports')</span>
                    </a>
                </li>         
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
