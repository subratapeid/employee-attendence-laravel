<x-app-layout>

    <div class="pagetitle">
        <h1>Admin Dashboard</h1>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Total Attendance Card -->
                    <div class="col-xxl-3 col-md-4" id="attendance-card">
                        <div class="card info-card revenue-card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item filter-option" href="#"
                                            data-filter="today">Today</a></li>
                                    <li><a class="dropdown-item filter-option" href="#"
                                            data-filter="this_week">This Week</a></li>
                                    <li><a class="dropdown-item filter-option" href="#"
                                            data-filter="this_month">This Month</a></li>
                                    <li><a class="dropdown-item filter-option" href="#"
                                            data-filter="this_year">This Year</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">
                                    Employee Attended <br />
                                    <span id="attendance-filter-title">Today</span>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="attendance-count">0</h6>
                                        {{-- <span class="text-muted small pt-2 ps-1">Days</span> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Total Attendence Card -->

                    <!-- Total Leaves Card -->
                    <div class="col-xxl-3 col-md-4" id="leaves-card">
                        <div class="card info-card sales-card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item filter-option" href="#"
                                            data-filter="today">Today</a></li>
                                    <li><a class="dropdown-item filter-option" data-filter="this_week"
                                            href="#">This Week</a></li>
                                    <li><a class="dropdown-item filter-option" data-filter="this_month"
                                            href="#">This Month</a></li>
                                    <li><a class="dropdown-item filter-option" data-filter="this_year"
                                            href="#">This Year</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Employee On Leave <br /><span
                                        id="leaves-filter-title">Today</span></h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar-x text-warning"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="leaves-count">0</h6>
                                        {{-- <span class="text-muted small pt-2 ps-1">Days</span> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Leaves Card -->

                    <!-- Total Absent Card -->
                    <div class="col-xxl-3 col-md-4" id="absent-card">
                        <div class="card info-card sales-card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item filter-option" href="#"
                                            data-filter="today">Today</a></li>
                                    <li><a class="dropdown-item filter-option" data-filter="this_week"
                                            href="#">This Week</a></li>
                                    <li><a class="dropdown-item filter-option" data-filter="this_month"
                                            href="#">This Month</a></li>
                                    <li><a class="dropdown-item filter-option" data-filter="this_year"
                                            href="#">This Year</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Employee Absent <br /><span id="leaves-filter-title">Today</span>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar-x text-danger"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="absebnt-count">0</h6>
                                        {{-- <span class="text-muted small pt-2 ps-1">Days</span> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Absent Card -->

                    <!-- Ontime Card -->
                    <div class="col-xxl-3 col-md-4" id="ontime-card">
                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item filter-option" href="#"
                                            data-filter="today">Today</a></li>
                                    <li><a class="dropdown-item filter-option" data-filter="this_week"
                                            href="#">This Week</a></li>
                                    <li><a class="dropdown-item filter-option" data-filter="this_month"
                                            href="#">This Month</a></li>
                                    <li><a class="dropdown-item filter-option" data-filter="this_year"
                                            href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Ontime Attented<br /><span
                                        id="overtime-filter-title">Today</span></h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-check-double text-success"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="ontime-attended">0</h6>
                                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> -->
                                        {{-- <span class="text-muted small pt-2 ps-1">Hours</span> --}}

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- end Ontime Card -->

                    <!-- Late Arrivals Card -->
                    <div class="col-xxl-3 col-md-4" id="late-arrival-card">
                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item filter-option" data-filter="this_week"
                                            href="#">This Week</a></li>
                                    <li><a class="dropdown-item filter-option" data-filter="this_month"
                                            href="#">This Month</a></li>
                                    <li><a class="dropdown-item filter-option" data-filter="this_year"
                                            href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Late Arrivals <br /><span id="late-filter-title">This
                                        Week</span></h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="late-count">0</h6>
                                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> -->
                                        {{-- <span class="text-muted small pt-2 ps-1">Days</span> --}}

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Late Arrivals Card -->
                    <!-- Early Left Card -->
                    <div class="col-xxl-3 col-md-4" id="early-left-card">
                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item filter-option" data-filter="this_week"
                                            href="#">This Week</a></li>
                                    <li><a class="dropdown-item filter-option" data-filter="this_month"
                                            href="#">This Month</a></li>
                                    <li><a class="dropdown-item filter-option" data-filter="this_year"
                                            href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Early Left <br /><span id="early-left-filter-title">This
                                        Week</span></h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-walking"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="early-left-count">0</h6>
                                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> -->
                                        <span class="text-muted small pt-2 ps-1">Days</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Early Leaves Card -->


                </div><!-- End Left side columns -->

            </div>
    </section>

    <script src="assets/js/getAdminDashboardData.js"></script>

</x-app-layout>
