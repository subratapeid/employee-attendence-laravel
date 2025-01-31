<x-app-layout>
    <div class="pagetitle">
        <h1>All Leaves</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Leaves</li>
            </ol>
        </nav>
    </div>
    <section class="section leave">
        <div class="mb-3">
            <div class="row g-2 align-items-center justify-content-end ps-md-4 pe-md-4 pt-2">
                <!-- Create Button (4 columns) -->
                <div class="col-4 col-md-2 text-md-end">
                    <button id="apply-leave-btn" class="btn btn-primary w-100 w-md-auto">Apply Leave</button>
                </div>
            </div>
        </div>

        <!-- Leave Records Table -->
        <div class="table-responsive" style="min-height: 250px;">
            <table class="table table-striped table-bordered" id="leaveRecordsTable">
                <thead class="table-secondary">
                    <tr>
                        <th>SL No</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Days</th>
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>Apply Date</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Table rows will be inserted here -->
                </tbody>
            </table>
        </div>
    </section>

    <!-- Apply Leave Modal -->
    <div class="modal fade" id="applyLeaveModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Apply Leave</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="applyLeaveForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">From Date</label>
                                <input type="date" class="form-control" name="fromDate" required>
                                <div class="invalid-feedback">Please enter a date.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">To Date</label>
                                <input type="date" class="form-control" name="toDate" required>
                                <div class="invalid-feedback">Please enter a date.</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <input type="text" class="form-control" name="remarks" required>
                            <div class="invalid-feedback">Please enter a remarks.</div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Fetch leave data on page load
            fetchLeaves();

            function fetchLeaves() {
                // Show loading message before sending the request
                $('#leaveRecordsTable tbody').html(
                    '<tr><td colspan="7" class="text-center">Loading data, please wait...</td></tr>');

                $.ajax({
                    url: '{{ route('leaves.fetch') }}', // Route to fetch all leaves
                    method: 'GET',
                    success: function(response) {
                        // Clear previous table rows
                        $('#leaveRecordsTable tbody').empty();

                        if (response.success && response.data.length > 0) {
                            // Loop through each leave and append it to the table
                            $.each(response.data, function(index, leave) {
                                var leaveRow = '<tr>' +
                                    '<td>' + leave.sl_no + '</td>' +
                                    '<td>' + leave.from_date + '</td>' +
                                    '<td>' + leave.to_date + '</td>' +
                                    '<td>' + leave.days + '</td>' +
                                    '<td>' + leave.remarks + '</td>' +
                                    '<td>' + leave.status + '</td>' +
                                    '<td>' + leave.created_at + '</td>' +
                                    '</tr>';
                                $('#leaveRecordsTable tbody').append(leaveRow);
                            });
                        } else {
                            // Show "No records found" message
                            $('#leaveRecordsTable tbody').html(
                                '<tr><td colspan="7" class="text-center">No records found</td></tr>'
                                );
                        }
                    },
                    error: function(xhr) {
                        $('#leaveRecordsTable tbody').html(
                            '<tr><td colspan="7" class="text-center text-danger">Failed to fetch data. Please try again.</td></tr>'
                            );
                    }
                });
            }


            // Show the Apply Leave Modal
            $('#apply-leave-btn').click(function() {
                $('#applyLeaveModal').modal('show');
            });

            // On form submit
            $('#applyLeaveForm').on('submit', function(e) {
                e.preventDefault(); // Prevent form from reloading the page

                // Clear previous error messages
                $('.invalid-feedback').hide();

                // Get form data
                var formData = $(this).serialize();

                // Send AJAX request to submit leave
                $.ajax({
                    url: '{{ route('apply.leave') }}', // Route to your controller method
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // If success, close the modal and reset the form
                        if (response.success) {
                            $('#applyLeaveModal').modal('hide');
                            $('#applyLeaveForm')[0].reset();
                            alert('Leave application submitted successfully.');
                            fetchLeaves(); // Refresh the leave data
                        }
                    },
                    error: function(xhr) {
                        // If there are validation errors
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            // Display validation error messages
                            $('[name=' + key + ']').addClass('is-invalid');
                            $('[name=' + key + ']').next('.invalid-feedback').text(
                                value).show();
                        });
                    }
                });
            });
        });
    </script>
</x-app-layout>
