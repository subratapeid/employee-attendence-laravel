<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="logo desktop d-flex align-items-center">
            <img src="{{ asset('assets/img/logo4.png') }}" alt="">
        </a>
        {{-- <i class="bi bi-list toggle-sidebar-btn"></i> --}}
        <i class="fas fa-bars toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->
    <div class="d-flex allign-items-center justify-content-center" id="duty-btn">
        {{-- <a href="{{ route('dashboard') }}" class="logo mobile d-flex align-items-center">
            <img src="/assets/img/logo3.png" alt="">
        </a> --}}
        @can('create-attendance')
            <div class="toggle-container mobile">
                <input type="checkbox" id="toggle" class="toggle-input" />
                <label for="toggle" class="toggle-label">
                    <span class="toggle-circle"></span>
                    <span class="toggle-text off">Day Begain</span>
                    <span class="toggle-text on">Day End</span>
                </label>
            </div>
        @endcan

    </div>
    {{-- <!-- <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
      
    </div> --> --}}
    <!-- End Search Bar -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ Auth::user()->img ? asset(Auth::user()->img) : asset('assets/img/user.png') }}"
                        alt="Profile" class="nav-profile-img">

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
    <div class="d-flex allign-items-center justify-content-center mb-3">
        <a href="{{ route('dashboard') }}" class="logo mobile">
            <img src="{{ asset('assets/img/logo4.png')}}" alt="">
        </a>
    </div>
    <ul class="sidebar-nav" id="sidebar-nav">
        @can('create-attendance')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('summary') ? '' : 'collapsed' }}" href="{{ route('summary') }}">
                    <i class="fa-solid fa-gauge"></i>
                    <span>Summary</span>
                </a>
            </li><!-- End Dashboard Nav -->
        @endcan
        @can('create-attendance')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('transactions.index') ? '' : 'collapsed' }}"
                    href="{{ route('transactions.index') }}">
                    <i class="fa-solid fa-file"></i>
                    <span>Day End Report</span>
                </a>
            </li><!-- End Dashboard Nav -->
        @endcan
        {{-- admin Dashboard --}}
        @can('view-report')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}"
                    href="{{ route('dashboard') }}">
                    <i class="fas fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->
        @endcan
        @can('create-attendance')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('leaves') ? '' : 'collapsed' }}" href="{{ route('leaves') }}">
                    <i class="fa-solid fa-person-running"></i>
                    <span>Leaves</span>
                </a>
            </li><!-- End Leaves Page Nav -->
        @endcan

        @can('create-attendance')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('activity-log') ? '' : 'collapsed' }}"
                    href="{{ route('activity-log') }}">
                    <i class="fa-solid fa-list-check"></i>
                    <span>Attendance Log</span>
                </a>
            </li>
        @endcan
        <!-- End activity-log Page Nav -->

        <!-- Calender Page Nav -->
        @can('create-attendance')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('calender') ? '' : 'collapsed' }}"
                    href="{{ route('calender') }}">
                    <i class="fa-regular fa-calendar-days"></i>
                    <span>Calender</span>
                </a>
            </li>
        @endcan
        <!-- End my-attendence Page Nav -->
        @can('edit-user')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('employees.index') ? '' : 'collapsed' }}"
                    href="{{ route('employees.index') }}">
                    <i class="fas fa-user-check"></i>
                    <span>Emp Attendance</span>
                </a>
            </li>
        @endcan
        <!-- End Employees Page Nav -->
        @can('view-report')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('reports') ? '' : 'collapsed' }}" href="{{ route('reports') }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Reports</span>
                </a>
            </li>
        @endcan
        <!-- End Report Page Nav -->
        @can('view-holiday')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('holiday.index') ? '' : 'collapsed' }}"
                    href="{{ route('holiday.index') }}">
                    <i class="far fa-calendar-times"></i>
                    <span>Holiday List</span>
                </a>
            </li>
        @endcan
        <!-- End Report Page Nav -->
        @can('view-permission')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('permissions.index') ? '' : 'collapsed' }}"
                    href="{{ route('permissions.index') }}">
                    <i class="fas fa-shield-alt"></i>
                    <span>Permissions</span>
                </a>
            </li>
        @endcan
        @can('view-role')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('roles.index') ? '' : 'collapsed' }}"
                    href="{{ route('roles.index') }}">
                    <i class="fas fa-user-shield"></i>
                    <span>Roles</span>
                </a>
            </li>
        @endcan
        @can('view-user')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('users.index') ? '' : 'collapsed' }}"
                    href="{{ route('users.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
        @endcan
        {{-- @can('bulk-import')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.import') ? '' : 'collapsed' }}"
                    href="{{ route('user.import') }}">
                    <i class="far fa-address-book"></i>
                    <span>Import Users</span>
                </a>
            </li>
        @endcan --}}
        <!-- End User Import Page Nav -->
    </ul>

</aside><!-- End Sidebar-->
