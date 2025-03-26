$(document).ready(function () {
    // Function to fetch working hours and update the card
    function fetchWorkingHours(filter) {
        // Show loading state
        $('#working-hours').text('Loading...');
        $('#filter-label').text(filter.replace('_', ' ').toUpperCase());

        // Make AJAX request
        $.ajax({
            url: getTotalWorkingHours, // Update this to your backend route
            method: 'GET',
            data: { filter: filter },
            success: function (response) {
                // Update the card with fetched data
                $('#working-hours').text(response.total_working_hours);
            },
            error: function () {
                alert('Error fetching data. Please try again.');
                $('#working-hours').text('0');
            }
        });
    }

    // Function to fetch attendance data and update the card
    function fetchAttendanceData(filter) {
        // Show loading state
        $('#attendance-count').text('Loading...');
        const filterTitleMap = {
            'this_week': 'This Week',
            'this_month': 'This Month',
            'this_year': 'This Year',
        };
        $('#attendance-filter-title').text(filterTitleMap[filter] || 'Custom');

        // Make AJAX request
        $.ajax({
            url: getAttendanceCount, // Update this to your backend route
            method: 'GET',
            data: { filter: filter },
            success: function (response) {
                // Update the card with fetched data
                $('#attendance-count').text(response.attendance_count || 0);
            },
            error: function () {
                alert('Error fetching attendance data. Please try again.');
                $('#attendance-count').text('0');
            }
        });
    }

    // Function to fetch leave data
    function fetchLeaveData(filter) {
        // Update UI for filter title
        const filterTitleMap = {
            'this_week': 'This Week',
            'this_month': 'This Month',
            'this_year': 'This Year',
        };
        $('#leaves-filter-title').text(filterTitleMap[filter] || 'Custom');

        // Show loading state
        $('#leaves-count').text('Loading...');

        // Make AJAX request to fetch leave data
        $.ajax({
            url: getTotalLeaves, // Update this to your backend route
            method: 'GET',
            data: { filter: filter },
            success: function (response) {
                // Update leave count in the UI
                $('#leaves-count').text(response.leave_count || 0);
            },
            error: function () {
                alert('Error fetching leave data. Please try again.');
                $('#leaves-count').text('0');
            }
        });
    }

    // Function to fetch leave data
    function fetchLateArrivalData(filter) {
        // Update UI for filter title
        const filterTitleMap = {
            'this_week': 'This Week',
            'this_month': 'This Month',
            'this_year': 'This Year',
        };
        $('#late-filter-title').text(filterTitleMap[filter] || 'Custom');

        // Show loading state
        $('#late-count').text('Loading...');

        // Make AJAX request to fetch leave data
        $.ajax({
            url: getLateArrivals, // Update this to your backend route
            method: 'GET',
            data: { filter: filter },
            success: function (response) {
                // Update leave count in the UI
                $('#late-count').text(response.late_arrival_count || 0);
            },
            error: function () {
                alert('Error fetching leave data. Please try again.');
                $('#leaves-count').text('0');
            }
        });
    }

    // Function to fetch early left data
    function fetchEarlyLeftData(filter) {
        // Update UI for filter title
        const filterTitleMap = {
            'this_week': 'This Week',
            'this_month': 'This Month',
            'this_year': 'This Year',
        };
        $('#early-left-filter-title').text(filterTitleMap[filter] || 'Custom');

        // Show loading state
        $('#early-left-count').text('Loading...');

        // Make AJAX request to fetch leave data
        $.ajax({
            url: getEarlyDepartures, // Update this to your backend route
            method: 'GET',
            data: { filter: filter },
            success: function (response) {
                // Update leave count in the UI
                $('#early-left-count').text(response.early_departure_count || 0);
            },
            error: function () {
                alert('Error fetching leave data. Please try again.');
                $('#leaves-count').text('0');
            }
        });
    }

    // Function to overtime data
    function fetchOvertimeData(filter) {
        // Update UI for filter title
        const filterTitleMap = {
            'this_week': 'This Week',
            'this_month': 'This Month',
            'this_year': 'This Year',
        };
        $('#overtime-filter-title').text(filterTitleMap[filter] || 'Custom');

        // Show loading state
        $('#overtime-hours').text('Loading...');

        // Make AJAX request to fetch leave data
        $.ajax({
            url: getOvertime, // Update this to your backend route
            method: 'GET',
            data: { filter: filter },
            success: function (response) {
                // Update leave count in the UI
                $('#overtime-hours').text(response.total_overtime || 0);
            },
            error: function () {
                alert('Error fetching leave data. Please try again.');
                $('#overtime-hours').text('0');
            }
        });
    }

    // Handle filter option click for both cards
    // Event listeners for filter options in each card
    $('#working-hours-card .filter-option').on('click', function (e) {
        e.preventDefault();
        const filter = $(this).data('filter');
        fetchWorkingHours(filter);
    });

    $('#attendance-card .filter-option').on('click', function (e) {
        e.preventDefault();
        const filter = $(this).data('filter');
        fetchAttendanceData(filter);
    });

    $('#leaves-card .filter-option').on('click', function (e) {
        e.preventDefault();
        const filter = $(this).data('filter');
        fetchLeaveData(filter);
    });
    $('#late-arrival-card .filter-option').on('click', function (e) {
        e.preventDefault();
        const filter = $(this).data('filter');
        fetchLateArrivalData(filter);
    });
    $('#early-left-card .filter-option').on('click', function (e) {
        e.preventDefault();
        const filter = $(this).data('filter');
        fetchEarlyLeftData(filter);
    });
    $('#overtime-card .filter-option').on('click', function (e) {
        e.preventDefault();
        const filter = $(this).data('filter');
        fetchOvertimeData(filter);
    });


    // Function to fetch all attendance data and update the UI
    function fetchAllAttendanceData() {
        // Show loading state for each section
        $('#working-hours').text('Loading...');
        $('#attendance-count').text('Loading...');
        $('#leaves-count').text('Loading...');
        $('#late-count').text('Loading...');
        $('#early-left-count').text('Loading...');
        $('#overtime-hours').text('Loading...');

        // Make AJAX request to fetch all data at once
        $.ajax({
            url: dashboardData,  // This should be the route for your `getAllAttendanceData` method
            method: 'GET',
            success: function (response) {
                if (response.success) {
                    // Update UI with the fetched data
                    $('#working-hours').text(response.total_working_hours);
                    $('#attendance-count').text(response.attendance_count);
                    $('#leaves-count').text(response.total_leaves);
                    $('#late-count').text(response.late_arrival_count);
                    $('#early-left-count').text(response.early_departure_count);
                    $('#overtime-hours').text(response.overtime);
                }
            },
            error: function () {
                alert('Error fetching data. Please try again.');
                $('#working-hours').text('0');
                $('#attendance-count').text('0');
                $('#leaves-count').text('0');
                $('#late-count').text('0');
                $('#early-left-count').text('0');
                $('#overtime-hours').text('0');
            }
        });
    }
    // Fetch all data on page load
    fetchAllAttendanceData();

});


