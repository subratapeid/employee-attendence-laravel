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

    <section class="section report mt-4 min-vh-100">
        {{-- <div class="container"> --}}
        <div class="row g-4">
            <!-- Employee Attendance Report Card -->
            <div class="col-12 col-md-6">
                <div class="card shadow-sm border-0 p-3 position-relative" id="attendance-card">
                    <!-- Filter Dropdown for Employee Attendance -->
                    <div class="filter position-absolute top-0 end-0 m-3">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item filter-option" data-filter="this_month" href="#"
                                    data-report="attendance">This Month</a></li>
                            <li><a class="dropdown-item filter-option" data-filter="previous_month" href="#"
                                    data-report="attendance">Previous Month</a></li>
                            <li><a class="dropdown-item filter-option" data-filter="this_year" href="#"
                                    data-report="attendance">This Year</a></li>
                            <li><a class="dropdown-item filter-option" data-filter="previous_year" href="#"
                                    data-report="attendance">Previous Year</a></li>
                        </ul>
                    </div>

                    <h5 class="report-card-title text-center pe-3">Employee Attendance Report</h5>
                    <h6 class="report-card-title text-center text-muted" id="selected-filter-attendance">This Month
                    </h6>

                    <div
                        class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 mb-4 mt-3">
                        <!-- First Statistic -->
                        <div class="d-flex align-items-center w-100">
                            <div class="card-icon bg-primary text-white p-3 rounded-circle me-3">
                                <i class="bi bi-person-check" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Attendance</h6>
                                <h4 class="fw-bold" id="attendance-stat-1">150</h4>
                            </div>
                        </div>

                        <!-- Second Statistic -->
                        <div class="d-flex align-items-center w-100">
                            <div class="card-icon bg-danger text-white p-3 rounded-circle me-3">
                                <i class="bi bi-person-dash" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Absent</h6>
                                <h4 class="fw-bold" id="attendance-stat-2">10</h4>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="btn btn-primary w-100" id="attendance-export-btn">
                        <i class="bi bi-download"></i> Download Report
                    </a>
                </div>
            </div>

            <!-- Employee Activity Report Card -->
            <div class="col-12 col-md-6">
                <div class="card shadow-sm border-0 p-3 position-relative" id="activity-card">
                    <!-- Filter Dropdown for Employee Activity -->
                    <div class="filter position-absolute top-0 end-0 m-3">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>

                            <li><a class="dropdown-item filter-option" data-filter="this_month" href="#"
                                    data-report="activity">This Month</a></li>
                            <li><a class="dropdown-item filter-option" data-filter="previous_month" href="#"
                                    data-report="activity">Previous Month</a></li>
                            <li><a class="dropdown-item filter-option" data-filter="this_year" href="#"
                                    data-report="activity">This Year</a></li>
                            <li><a class="dropdown-item filter-option" data-filter="previous_year" href="#"
                                    data-report="activity">Previous Year</a></li>
                        </ul>
                    </div>

                    <h5 class="report-card-title text-center">Employee Activity Report</h5>
                    <h6 class="report-card-title text-center text-muted" id="selected-filter-activity">This Month
                    </h6>

                    {{-- <div class="d-flex align-items-center justify-content-center gap-5 mb-4 mt-4"> --}}
                    <div
                        class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 mb-4 mt-3">

                        <!-- First Statistic -->
                        <div class="d-flex align-items-center w-100">
                            <div class="card-icon bg-success text-white p-3 rounded-circle me-3">
                                <i class="bi bi-check-circle" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Transactions</h6>
                                <h4 class="fw-bold" id="activity-stat-1">200</h4>
                            </div>
                        </div>

                        <!-- Second Statistic -->
                        <div class="d-flex align-items-center w-100">
                            <div class="card-icon bg-warning text-white p-3 rounded-circle me-3">
                                <i class="bi bi-exclamation-circle" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Enrolments</h6>
                                <h4 class="fw-bold" id="activity-stat-2">5</h4>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="btn btn-primary w-100" id="activity-export-btn">
                        <i class="bi bi-download"></i> Download Report
                    </a>
                </div>
            </div>

        </div>
        </div>
    </section>

    <!-- jQuery Script to Handle Filter Change per Card and Export -->
    <script>
        // $(document).ready(function() {
        //     // Default Filter on Page Load (This Month)
        //     loadReportData('attendance', 'this_month');
        //     loadReportData('activity', 'this_month');

        //     // When filter option is clicked for a specific card
        //     $('.filter-option').on('click', function(e) {
        //         e.preventDefault();

        //         var selectedFilter = $(this).data('filter'); // Get the selected filter
        //         var reportName = $(this).data('report'); // Get the report name for the card

        //         // Update the filter title for the specific card
        //         $('#selected-filter-' + reportName).text(selectedFilter.charAt(0).toUpperCase() +
        //             selectedFilter.slice(1).replace('_', ' '));

        //         // Remove 'active' class from all filter options and add to the selected one
        //         $('.filter-option').removeClass('active'); // Remove 'active' from all filter options
        //         $(this).addClass('active'); // Add 'active' to the clicked filter option

        //         // Load the data based on the selected filter
        //         loadReportData(reportName, selectedFilter);
        //     });

        //     // Export functionality for Attendance report
        //     $('#attendance-export-btn').click(function() {
        //         var filter = $('#selected-filter-attendance').text().toLowerCase().replace(' ', '_');
        //         window.location.href = "/export/csv?report=attendance&filter=" + filter;
        //     });

        //     // Export functionality for Activity report
        //     $('#activity-export-btn').click(function() {
        //         var filter = $('#selected-filter-activity').text().toLowerCase().replace(' ', '_');
        //         window.location.href = "/export/csv?report=activity&filter=" + filter;
        //     });
        // });

        // // Function to Load Report Data based on Filter
        // function loadReportData(report, filter) {
        //     // Set Loading State
        //     $('#' + report + '-stat-1').text('Loading...');
        //     $('#' + report + '-stat-2').text('Loading...');

        //     $.ajax({
        //         url: '/reports/filter', // Modify this URL with your controller's endpoint
        //         type: 'GET',
        //         data: {
        //             report: report,
        //             filter: filter
        //         },
        //         beforeSend: function() {
        //             // Optionally show a loading spinner or message while waiting for response
        //             console.log("Loading data for " + report + "...");
        //         },
        //         success: function(response) {
        //             if (response && response.total !== undefined && response.pending !== undefined) {
        //                 $('#' + report + '-stat-1').text(response.total); // Update total value
        //                 $('#' + report + '-stat-2').text(response.pending); // Update pending value
        //             } else {
        //                 showError(report); // Show error if response data is unexpected
        //             }
        //         },
        //         error: function(err) {
        //             console.error("Error:", err);
        //             showError(report); // Show error message in case of failure
        //         }
        //     });
        // }

        // // Function to Show Error State
        // function showError(report) {
        //     $('#' + report + '-stat-1').text('0'); // Default to 0 if error occurs
        //     $('#' + report + '-stat-2').text('0'); // Default to 0 if error occurs
        //     alert("Error loading data for " + report);
        // }



        $(document).ready(function() {
            // Load both reports' data on page load (This Month by default)
            // loadInitialReportData();

            // When filter option is clicked for a specific card
            $('.filter-option').on('click', function(e) {
                e.preventDefault();

                var selectedFilter = $(this).data('filter'); // Get the selected filter
                var reportName = $(this).data('report'); // Get the report name for the card

                // Update the filter title for the specific card
                $('#selected-filter-' + reportName).text(selectedFilter.charAt(0).toUpperCase() +
                    selectedFilter.slice(1).replace('_', ' '));

                // Remove 'active' class from all filter options and add to the selected one
                $('.filter-option').removeClass('active'); // Remove 'active' from all filter options
                $(this).addClass('active'); // Add 'active' to the clicked filter option

                // Load the data based on the selected filter
                loadReportData(reportName, selectedFilter);
            });

            // Export functionality for Attendance report
            $('#attendance-export-btn').click(function() {
                var filter = $('#selected-filter-attendance').text().toLowerCase().replace(' ', '_');
                // window.location.href = "/export/csv?report=attendance&filter=" + filter;
                window.location.href = "export-xls?report=attendance&filter=" + filter;

            });

            // Export functionality for Activity report
            $('#activity-export-btn').click(function() {
                var filter = $('#selected-filter-activity').text().toLowerCase().replace(' ', '_');
                window.location.href = "export/csv?report=activity&filter=" + filter;
            });
        });

        // Function to Load Both Report Data (attendance and activity) on Page Load
        function loadInitialReportData() {
            // Set Loading State
            $('#attendance-stat-1, #attendance-stat-2').text('Loading...');
            $('#activity-stat-1, #activity-stat-2').text('Loading...');

            $.ajax({
                url: '/reports/filter', // Modify this URL with your controller's endpoint
                type: 'GET',
                data: {
                    report: 'both', // We'll use a special 'both' report flag to fetch both reports
                    filter: 'this_month' // Default filter
                },
                beforeSend: function() {
                    console.log("Loading both reports data...");
                },
                success: function(response) {
                    // Handle the success response for both reports
                    if (response.attendance && response.activity) {
                        // Update stats for attendance
                        $('#attendance-stat-1').text(response.attendance.total);
                        $('#attendance-stat-2').text(response.attendance.pending);

                        // Update stats for activity
                        $('#activity-stat-1').text(response.activity.total);
                        $('#activity-stat-2').text(response.activity.pending);
                    } else {
                        showError(); // Show error if response is not in the expected format
                    }
                },
                error: function(err) {
                    console.error("Error:", err);
                    showError(); // Show error message in case of failure
                }
            });
        }

        // Function to Load Report Data based on Filter for Each Report
        function loadReportData(report, filter) {
            // Set Loading State
            $('#' + report + '-stat-1').text('Loading...');
            $('#' + report + '-stat-2').text('Loading...');

            $.ajax({
                url: '/reports/filter', // Modify this URL with your controller's endpoint
                type: 'GET',
                data: {
                    report: report, // Specify the report (attendance or activity)
                    filter: filter // The selected filter
                },
                success: function(response) {
                    if (response && response.total !== undefined && response.pending !== undefined) {
                        $('#' + report + '-stat-1').text(response.total); // Update total value
                        $('#' + report + '-stat-2').text(response.pending); // Update pending value
                    } else {
                        showError(report); // Show error if response data is unexpected
                    }
                },
                error: function(err) {
                    console.error("Error:", err);
                    showError(report); // Show error message in case of failure
                }
            });
        }

        // Function to Show Error State
        function showError(report) {
            if (report) {
                $('#' + report + '-stat-1').text('0'); // Default to 0 if error occurs
                $('#' + report + '-stat-2').text('0'); // Default to 0 if error occurs
            } else {
                // Show error for both reports if needed
                $('#attendance-stat-1, #attendance-stat-2').text('0');
                $('#activity-stat-1, #activity-stat-2').text('0');
            }
            alert("Error loading data. Please try again.");
        }
    </script>

</x-app-layout>
