<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
            <img src="/assets/img/logo.png" alt="">
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->

    <div class="d-flex allign-items-center justify-content-center" id="duty-btn">
        <div class="toggle-container">
            <input type="checkbox" id="toggle" class="toggle-input" />
            <label for="toggle" class="toggle-label">
                <span class="toggle-circle"></span>
                <span class="toggle-text off">Off Duty</span>
                <span class="toggle-text on">On Duty</span>
            </label>
        </div>
    </div>
    <!-- <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
      
    </div> -->
    <!-- End Search Bar -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ Auth::user()->img ? asset(Auth::user()->img) : asset('assets/img/profile-img.jpg') }}"
                        alt="Profile" class="rounded-circle">

                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->name }}</h6>

                        <span>{{ Auth::user()->roles->pluck('name')->implode(', ') }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    {{-- <li>
                        <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                            <i class="bi bi-gear"></i>
                            <span>Account Settings</span>
                        </a>
                    </li> --}}
                    {{-- <li>
                        <hr class="dropdown-divider">
                    </li> --}}

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        @can('view-attendance')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}"
                    href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-gauge"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->
        @endcan
        @can('view-attendance')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('leaves') ? '' : 'collapsed' }}" href="{{ route('leaves') }}">
                    <i class="fa-solid fa-person-running"></i>
                    <span>Leaves</span>
                </a>
            </li><!-- End Leaves Page Nav -->
        @endcan

        @can('view-attendance')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('activity-log') ? '' : 'collapsed' }}"
                    href="{{ route('activity-log') }}">
                    <i class="fa-solid fa-list-check"></i>
                    <span>Activit Log</span>
                </a>
            </li>
        @endcan
        <!-- End activity-log Page Nav -->

        <!-- Calender Page Nav -->
        @can('view-attendance')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('calender') ? '' : 'collapsed' }}"
                    href="{{ route('calender') }}">
                    <i class="fa-regular fa-calendar-days"></i>
                    <span>Calender</span>
                </a>
            </li>
        @endcan
        <!-- End my-attendence Page Nav -->
        @can('view-employee')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('employees.index') ? '' : 'collapsed' }}"
                    href="{{ route('employees.index') }}">
                    <i class="fas fa-user-tie"></i>
                    <span>Employees</span>
                </a>
            </li>
        @endcan
        <!-- End Employees Page Nav -->
        @can('view-report')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('reports') ? '' : 'collapsed' }}" href="{{ route('reports') }}">
                    <i class="fas fa-chart-pie"></i>
                    <span>Reports</span>
                </a>
            </li>
        @endcan
        <!-- End Report Page Nav -->
        @can('view-permission')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.import') ? '' : 'collapsed' }}"
                    href="{{ route('permissions.index') }}">
                    <i class="fas fa-shield-alt"></i>
                    <span>Permissions</span>
                </a>
            </li>
        @endcan
        @can('view-roles')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.import') ? '' : 'collapsed' }}"
                    href="{{ route('roles.index') }}">
                    <i class="fas fa-user-shield"></i>
                    <span>Roles</span>
                </a>
            </li>
        @endcan
        @can('view-user')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.import') ? '' : 'collapsed' }}"
                    href="{{ route('users.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
        @endcan
        @can('bulk-import')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.import') ? '' : 'collapsed' }}"
                    href="{{ route('user.import') }}">
                    <i class="far fa-address-book"></i>
                    <span>Import Users</span>
                </a>
            </li>
        @endcan
        <!-- End User Import Page Nav -->
    </ul>

</aside><!-- End Sidebar-->
