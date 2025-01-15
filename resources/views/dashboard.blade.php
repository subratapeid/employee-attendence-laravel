<x-app-layout>

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Working Hours Card -->
                    <div class="col-xxl-3 col-md-4">

                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Total Working Hours <br /><span>Today</span></h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>145</h6>
                                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> -->
                                        <span class="text-muted small pt-2 ps-1">Hours</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Working Hours Card -->

                    <!-- Total Attendence Card -->
                    <div class="col-xxl-3 col-md-4">

                        <div class="card info-card revenue-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">This Week</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Total Attendence <br /><span>This Week</span></h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>4</h6>
                                        <!-- <span class="text-success small pt-1 fw-bold">8%</span> -->
                                        <span class="text-muted small pt-2 ps-1">Days</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Total Attendence Card -->

                    <!-- Leaves Card -->
                    <div class="col-xxl-3 col-md-4">

                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">This Week</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Total Leaves <br /><span>This Week</span></h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar-x text-danger"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>2</h6>
                                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> -->
                                        <span class="text-muted small pt-2 ps-1">Days</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Leaves Card -->

                    <!-- Late Arrivals Card -->
                    <div class="col-xxl-3 col-md-4">
                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">This Week</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Late Arrivals <br /><span>This Week</span></h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>2</h6>
                                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> -->
                                        <span class="text-muted small pt-2 ps-1">Days</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Late Arrivals Card -->
                    <!-- Early Leaves Card -->
                    <div class="col-xxl-3 col-md-4">
                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">This Week</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Early Leaves <br /><span>This Week</span></h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-walking"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>3</h6>
                                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> -->
                                        <span class="text-muted small pt-2 ps-1">Days</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Early Leaves Card -->

                    <!-- Overtime Card -->
                    <div class="col-xxl-3 col-md-4">
                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">This Week</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Overtime Hours <br /><span>This Week</span></h5>

                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-crown text-warning"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>14</h6>
                                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> -->
                                        <span class="text-muted small pt-2 ps-1">Hours</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- end Overtime Hours Card -->
                </div><!-- End Left side columns -->

            </div>
    </section>


</x-app-layout>
