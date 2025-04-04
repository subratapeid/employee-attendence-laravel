<x-app-layout>
    <div class="pagetitle">
        <h1>All Reports</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Reports</li>
            </ol>
        </nav>
    </div>
    <div id="calendar-overlay" style="display: none;"></div>

    <section class="section report mt-4 min-vh-100">
        <div class="row g-4">
            <!-- Employee Attendance Report -->
            <div class="col-12 col-md-6">
                <div class="card shadow-sm border-0 p-3 position-relative" id="attendance-card">
                    <div class="filter position-absolute top-0 end-0 m-3">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start"><h6>Filter</h6></li>
                            <li><a class="dropdown-item filter-option" data-filter="this_month" href="#" data-report="attendance">This Month</a></li>
                            <li><a class="dropdown-item filter-option" data-filter="previous_month" href="#" data-report="attendance">Previous Month</a></li>
                            <li><a class="dropdown-item filter-option" data-filter="this_year" href="#" data-report="attendance">This Year</a></li>
                            <li><a class="dropdown-item filter-option" data-filter="previous_year" href="#" data-report="attendance">Previous Year</a></li>
                        </ul>
                    </div>

                    <h5 class="report-card-title text-center pe-3">Employee Attendance Report</h5>
                    <h6 class="report-card-title text-center text-muted" id="selected-filter-attendance">This Month</h6>

                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 mb-4 mt-3">
                        <div class="d-flex align-items-center w-100">
                            <div class="card-icon bg-primary text-white p-3 rounded-circle me-3">
                                <i class="bi bi-person-check" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Attendance</h6>
                                <h4 class="fw-bold" id="attendance-stat-1">0</h4>
                            </div>
                        </div>

                        <div class="d-flex align-items-center w-100">
                            <div class="card-icon bg-danger text-white p-3 rounded-circle me-3">
                                <i class="bi bi-person-dash" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Absent</h6>
                                <h4 class="fw-bold" id="attendance-stat-2">0</h4>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="btn btn-primary w-100" id="attendance-export-btn">
                        <i class="bi bi-download"></i> Download Report
                    </a>
                </div>
            </div>

            <!-- Employee Activity Report -->
            <div class="col-12 col-md-6">
                <div class="card shadow-sm border-0 p-3 position-relative" id="activity-card">
                    <div class="filter position-absolute top-0 end-0 m-3">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start"><h6>Filter</h6></li>
                            <li><a class="dropdown-item filter-option" data-filter="today" href="#" data-report="activity">Today</a></li>
                            <li><a class="dropdown-item filter-option" data-filter="yesterday" href="#" data-report="activity">Yesterday</a></li>
                            <li>
                                <a class="dropdown-item" id="customDatePickerTrigger" href="#" data-report="activity" data-filter="custom">Custom Date</a>
                              </li>
                        </ul>
                    </div>

                    <h5 class="report-card-title text-center">Employee Activity Report</h5>
                    <h6 class="report-card-title text-center text-muted" id="selected-filter-activity">Today</h6>

                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 mb-4 mt-3">
                        <div class="d-flex align-items-center w-100">
                            <div class="card-icon bg-success text-white p-3 rounded-circle me-3">
                                <i class="bi bi-check-circle" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Transactions</h6>
                                <h4 class="fw-bold" id="activity-stat-1">0</h4>
                            </div>
                        </div>

                        <div class="d-flex align-items-center w-100">
                            <div class="card-icon bg-warning text-white p-3 rounded-circle me-3">
                                <i class="bi bi-exclamation-circle" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Enrolments</h6>
                                <h4 class="fw-bold" id="activity-stat-2">0</h4>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="btn btn-primary w-100" id="activity-export-btn">
                        <i class="bi bi-download"></i> Download Report
                    </a>
                </div>
            </div>
        </div>
        {{-- <input type="date" id="hiddenCustomDateInput" style="opacity: 0; position: absolute; z-index: 9999; width: 1px; height: 1px; top: 0; left: 0;" /> --}}
        <input type="text" id="hiddenCustomDateInput" class="form-control d-none" />


    </section>
    <style>
        /* Blur & dark background behind calendar */
        #calendar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            backdrop-filter: blur(5px);
            background-color: rgba(0, 0, 0, 0.342);
            z-index: 99998;
        }
    
        /* Center the calendar popup */
        .flatpickr-calendar {
            position: fixed !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            z-index: 99999 !important;
        }
        .flatpickr-day.flatpickr-disabled {
        color: rgb(13 13 13 / 40%) !important; /* Light but readable */
        /* background-color: #f9f9f9 !important; Slight grey background */
        cursor: not-allowed !important;
        }
    </style>
    
    

    <!-- jQuery Script -->
    <!-- 👇 Hidden input for custom date -->

<script>
    $(document).ready(function () {
        $('a[href="#"]').on('click', function (e) {
    e.preventDefault(); // Stop that annoying # and page scroll
});

        // 👇 Load default data for both cards
        loadInitialReportData();

        // 👇 Handle filter change
        $('.filter-option').on('click', function (e) {
            e.preventDefault();
            const selectedFilter = $(this).data('filter');
            const report = $(this).data('report');

            // Skip if custom filter
            if (selectedFilter === 'custom') return;

            // Format label
            const formatted = selectedFilter.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            $('#selected-filter-' + report).text(formatted);

            $('.filter-option').removeClass('active');
            $(this).addClass('active');

            loadReportData(report, selectedFilter);
        });
        
        
        const customDateInput = document.getElementById("hiddenCustomDateInput");

const flatpickrInstance = flatpickr(customDateInput, {
    dateFormat: "Y-m-d",
    clickOpens: false,
    defaultDate: null,
    allowInput: true,
    maxDate: "today",

    onChange: function (selectedDates, dateStr, instance) {
        if (selectedDates.length > 0) {
            $('#calendar-overlay').hide(); // ✅ hide overlay on selection
            $('#selected-filter-activity').text("Date:" + dateStr);
            loadReportData('activity', dateStr.replace(/-/g, '_'));
        }
    },

    onClose: function() {
        $('#calendar-overlay').hide(); // just hide overlay, nothing else
    }
});

$('#customDatePickerTrigger').click(function (e) {
    e.preventDefault();
    $('#calendar-overlay').show();
    flatpickrInstance.open();
});

        

        // 👇 Attendance Export
        $('#attendance-export-btn').click(function () {
            const filter = $('#selected-filter-attendance').text().toLowerCase().replace(/ /g, '_');
            window.location.href = "export-xls?report=attendance&filter=" + filter;
        });

        // 👇 Activity Export
        $('#activity-export-btn').click(function () {
            const filter = $('#selected-filter-activity').text().toLowerCase().replace(/ /g, '_').replace('date:', '').trim();
            window.location.href = "export/csv?report=activity&filter=" + filter;
        });
    });

    function loadInitialReportData() {
        $('#attendance-stat-1, #attendance-stat-2, #activity-stat-1, #activity-stat-2').text('Loading...');
        $.ajax({
            url: '/reports/filter',
            method: 'GET',
            data: { report: 'both', filter: 'this_month' },
            success: function (res) {
                if (res.attendance) {
                    $('#attendance-stat-1').text(res.attendance.total);
                    $('#attendance-stat-2').text(res.attendance.pending);
                }
                if (res.activity) {
                    $('#activity-stat-1').text(res.activity.total);
                    $('#activity-stat-2').text(res.activity.pending);
                }
            },
            error: function () {
                showError();
            }
        });
    }

    function loadReportData(report, filter) {
        $('#' + report + '-stat-1, #' + report + '-stat-2').text('Loading...');

        $.ajax({
            url: '/reports/filter',
            method: 'GET',
            data: {
                report: report,
                filter: filter
            },
            success: function (res) {
                if (res.total !== undefined && res.pending !== undefined) {
                    $('#' + report + '-stat-1').text(res.total);
                    $('#' + report + '-stat-2').text(res.pending);
                } else {
                    // fallback for "both" response
                    if (res[report]) {
                        $('#' + report + '-stat-1').text(res[report].total);
                        $('#' + report + '-stat-2').text(res[report].pending);
                    } else {
                        showError(report);
                    }
                }
            },
            error: function () {
                showError(report);
            }
        });
    }

    function showError(report = null) {
        if (report) {
            $('#' + report + '-stat-1, #' + report + '-stat-2').text('0');
        } else {
            $('#attendance-stat-1, #attendance-stat-2, #activity-stat-1, #activity-stat-2').text('0');
        }
        alert('Error loading data. Please try again.');
    }
</script>

    
</x-app-layout>
