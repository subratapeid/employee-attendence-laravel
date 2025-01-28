<x-app-layout>

    <div class="pagetitle">
        <h1>All Users</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </nav>
    </div>
    <section class="section users">
        <div class="d-flex justify-content-between align-items-center mb-3 ps-2 pe-2">
            <select id="per_page" class="form-select w-auto">
                <option value="10">10</option>
                <option value="20" selected>20</option>
                <option value="50">50</option>
            </select>
            <button id="filterBtn" class="btn btn-secondary position-relative"><i class="fas fa-filter"></i>
                <span id="filter-count" class="filter-badge" style="display: none;">0</span>
            </button>
            <button id="searchBtnIcon" class="btn btn-primary mobile-visible"><i class="bi bi-search"></i></button>
            <div class="input-group w-50 mobile-hidden">
                <input type="text" id="search" class="form-control" placeholder="Search users">
                <button id="searchBtn" class="btn btn-primary">Search</button>
            </div>
            <button id="create-btn" class="btn btn-success position-relative">+ Create</button>
            <button id="exportBtn" class="btn btn-warning"><i class="far fa-file-excel"></i>
                Export</button>
        </div>
        <div id="employee-table" class="table-responsive">
            <!-- Employee table will be loaded here -->
        </div>
    </section>

    <!-- Search Overlay -->
    <div id="search-overlay" class="position-fixed top-0 start-0 w-100 h-100 ">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="bg-white p-4 rounded shadow-lg w-100" style="max-width: 400px;">
                <div class="input-group mb-3">
                    <input type="text" id="overlaySearch" class="form-control" placeholder="Enter search query">
                    <button id="overlaySearchBtn" class="btn btn-primary">Search</button>
                </div>
                <button id="closeSearchOverlay" class="btn btn-danger w-100">Close</button>
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Apply Filters</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <select id="role" class="form-select mb-3">
                        <option value="">All Roles</option>
                        <option value="employee">Employee</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                    <select id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="resetFilters">Reset</button>
                    <button type="button" class="btn btn-primary" id="applyFilters">Apply</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" required>
                                <div class="invalid-feedback">Please enter a name.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Emp Id</label>
                                <input type="text" class="form-control" name="emp_id" required>
                                <div class="invalid-feedback">Please enter employee id.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                                <div class="invalid-feedback">Please enter a valid email.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="number" class="form-control" name="phone" required>
                                <div class="invalid-feedback">Please enter a mobile no.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">State</label>
                                <select class="form-control" name="state" id="stateDropdown" required>
                                    <option value="" disabled selected>Select a state</option>
                                </select>
                                <div class="invalid-feedback">Please select a state.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">District</label>
                                <input type="text" class="form-control" name="district" required>
                                <div class="invalid-feedback">Please enter a district.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Latitude</label>
                                <input type="text" class="form-control" name="latitude" id="latitude" required>
                                <div class="invalid-feedback">Please enter a valid latitude (e.g., 123.12345678).
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Longitude</label>
                                <input type="text" class="form-control" name="longitude" id="longitude" required>
                                <div class="invalid-feedback">Please enter a valid longitude (e.g., 123.12345678).
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">User Role</label>
                                <Select class="form-control" name="role" id="role" required>
                                    <option value="Employee" Selected>Employee</option>
                                    <option value="User">User</option>
                                    <option value="Guest">Guest</option>
                                    <option value="Admin">Admin</option>
                                </Select>
                                <div class="invalid-feedback">Please enter a valid latitude (e.g., 123.12345678).
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary" id="createUser">Create User</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" id="edit_emp_id">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View User Modal -->
    <div class="modal fade" id="viewUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <img id="view_photo" src="assets/img/user.png" alt="Employee Photo"
                            class="img-fluid rounded-circle" width="120">
                    </div>
                    <p><strong>Name:</strong> <span id="view_name"></span></p>
                    <p><strong>Email:</strong> <span id="view_email"></span></p>
                    <p><strong>Phone:</strong> <span id="view_phone"></span></p>
                    <p><strong>Department:</strong> <span id="view_department"></span></p>
                </div>
            </div>
        </div>
    </div>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script>
        fetchEmployees();
        $('#create-btn').click(function() {
            $('#addUserModal').modal('show');
            fetchStates();
            // $('#addUserForm')[0].reset();
        });
        let appliedFilters = 0;

        function fetchEmployees(page = 1) {
            $('#loading-overlay').addClass('d-flex')
            let search = $('#search').val() || $('#overlaySearch').val();
            let role = $('#role').val();
            let status = $('#status').val();
            let perPage = $('#per_page').val();

            $.ajax({
                url: "{{ route('users.fetch') }}",
                method: 'GET',
                data: {
                    search,
                    role: role,
                    status: status,
                    page,
                    per_page: perPage
                },
                success: function(response) {
                    $('#loading-overlay').removeClass('d-flex')

                    let tableHtml = `
                            <div class="table-responsive" style="overflow-y: auto;">
                                <table class="table table-striped table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-nowrap text-center">SL No</th>
                                            <th class="text-nowrap text-center" style="min-width: 300px;">Name</th>
                                            <th class="text-nowrap text-center">Email</th>
                                            <th class="text-nowrap text-center">Role</th>
                                            <th class="text-nowrap text-center">Status</th>
                                            <th class="text-nowrap text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        `;



                    response.data.forEach(function(employee) {
                        tableHtml += '<tr><td>' + employee.sl_no + '</td>';
                        tableHtml += '<td>' + employee.name + '</td>';
                        tableHtml += '<td>' + employee.email + '</td>';
                        tableHtml += '<td>' + employee.roles + '</td>';
                        tableHtml += '<td>' + employee.status + '</td>';
                        tableHtml += '<td class="text-nowrap">';

                        // Conditionally render action buttons based on permissions
                        @canany(['view-user', 'edit-user', 'delete-user', 'reset-password'])
                            @can('edit-user')
                                tableHtml +=
                                    '<button class="btn btn-warning btn-sm edit-btn" data-id="' +
                                    employee.id + '">Edit</button> ';
                            @endcan
                            @can('delete-user')
                                tableHtml +=
                                    '<button class="btn btn-danger btn-sm delete-btn" data-id="' +
                                    employee.id + '">Delete</button> ';
                            @endcan
                            @can('view-user')
                                tableHtml += '<button class="btn btn-info btn-sm view-btn" data-id="' +
                                    employee.id + '">Details</button> ';
                            @endcan
                            @can('reset-password')
                                tableHtml +=
                                    '<button class="btn btn-secondary btn-sm reset-btn" data-id="' +
                                    employee.id + '">Reset Password</button>';
                            @endcan
                        @endcanany

                        tableHtml += '</td></tr>';
                    });

                    tableHtml += '</tbody></table></div>'; // Closing the scrollable div

                    let paginationHtml =
                        '<div class="d-flex justify-content-between align-items-center mt-3 ps-2 pe-2 pb-4">' +
                        '<span>Showing ' + response.from + ' to ' + response.to + ' of ' + response.total +
                        ' records</span>' +
                        '<div>' +
                        '<button class="btn btn-secondary me-2" onclick="fetchEmployees(' + (response
                            .current_page - 1) + ')" ' +
                        (response.prev_page_url ? '' : 'disabled') + '>Previous</button>' +
                        '<button class="btn btn-secondary" onclick="fetchEmployees(' + (response.current_page +
                            1) + ')" ' +
                        (response.next_page_url ? '' : 'disabled') + '>Next</button>' +
                        '</div></div>';

                    $('#employee-table').html(tableHtml + paginationHtml);



                    // Open Edit User Modal
                    $('.edit-btn').click(function() {
                        let empId = $(this).data('id');
                        $('#editUserModal').modal('show');
                        $.get(`/employee/${empId}`, function(data) {
                            $('#edit_emp_id').val(data.id);
                            $('#edit_name').val(data.name);
                            $('#edit_email').val(data.email);
                        });
                    });

                    // Open View User Modal
                    $('.view-btn').click(function() {
                        let empId = $(this).data('id');
                        $('#viewUserModal').modal('show');
                        $.get(`/employee/${empId}`, function(data) {
                            $('#view_photo').attr('src', data.photo);
                            $('#view_name').text(data.name);
                            $('#view_email').text(data.email);
                            $('#view_phone').text(data.phone);
                            $('#view_department').text(data.department);
                        });
                    });

                    // Delete Employee
                    $('.delete-btn').click(function() {
                        if (confirm("Are you sure you want to delete this user?")) {
                            let empId = $(this).data('id');
                            $.ajax({
                                url: `/employees/${empId}`,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    alert('User Deleted Successfully');
                                    fetchEmployees();

                                }
                            });
                        }
                    });

                    // Reset Password
                    $('.reset-btn').click(function() {
                        let empId = $(this).data('id');
                        if (confirm('Are you sure you want to reset the password?')) {
                            $.post("{{ url('/employees/reset-password') }}/" + empId, {
                                _token: '{{ csrf_token() }}'
                            }, function(response) {
                                alert(response.success + '\nNew Password: ' + response
                                    .new_password);
                            }).fail(function() {
                                alert('Failed to reset password.');
                            });
                        }
                    });
                },

                error: function() {
                    $('#loading-overlay').hide();
                    alert('Error fetching data');
                }
            });
        }

        $('#searchBtn, #overlaySearchBtn').on('click', function() {
            fetchEmployees();
            $('#search-overlay').removeClass('active');
        });


        $('#searchBtnIcon').on('click', function() {
            $('#search-overlay').addClass('active');
        });

        $('#closeSearchOverlay').on('click', function() {
            $('#search-overlay').removeClass('active');
        });

        // Close overlay when clicking outside the form area
        $(document).mouseup(function(e) {
            let container = $("#search-overlay .bg-white");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                $('#search-overlay').removeClass('active');
            }
        });

        $('#per_page').on('change', function() {
            fetchEmployees();
        });
        $('#filterBtn').on('click', function() {
            $('#filterModal').modal('show');
        });

        $('#applyFilters').on('click', function() {
            appliedFilters = ($('#role').val() ? 1 : 0) + ($('#status').val() ? 1 : 0);
            if (appliedFilters > 0) {
                $('#filter-count').text(appliedFilters).show();
            } else {
                $('#filter-count').hide();
            }
            $('#filterModal').modal('hide');
            fetchEmployees();
        });

        $('#resetFilters').on('click', function() {
            $('#department, #status').val('');
            $('#filter-count').hide();
        });

        $('#exportBtn').on('click', function() {
            let search = $('#search').val();
            let department = $('#department').val();
            let status = $('#status').val();
            window.location.href =
                `{{ route('employees.export') }}?search=${search}&department=${department}&status=${status}`;
        });

        function validateCoordinateInput(input) {
            let value = input.value;

            // Allow only numbers and a single decimal point
            value = value.replace(/[^0-9.]/g, '');

            // Prevent typing the decimal point if no digits are entered before
            if (value.startsWith('.')) {
                value = '0' + value; // Automatically add 0 before decimal
            }

            // Ensure only one decimal point is allowed
            let dotCount = (value.match(/\./g) || []).length;
            if (dotCount > 1) {
                value = value.substring(0, value.lastIndexOf('.')); // Remove the extra decimal
            }

            // Prevent entering more than 3 digits before the decimal point
            let parts = value.split('.');
            if (parts[0].length > 3) {
                parts[0] = parts[0].slice(0, 3); // Limit the number of digits before the decimal
            }

            // Ensure exactly 8 digits after the decimal point
            if (parts.length > 1) {
                parts[1] = parts[1].slice(0, 8); // Limit the number of digits after the decimal
                value = parts.join('.');
            } else {
                value = parts[0];
            }

            input.value = value;
        }

        $('#latitude, #longitude').on('input', function() {
            validateCoordinateInput(this);
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').hide();
        });

        $('#addUserForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var isValid = true;

            // Validate Latitude
            var latitude = $('#latitude').val();
            var latitudeRegex = /^[0-9]{1,3}(\.\d{8})$/; // Exactly 8 digits after the decimal
            if (!latitudeRegex.test(latitude)) {
                $('#latitude').addClass('is-invalid');
                $('#latitude').next('.invalid-feedback').text(
                    'Please enter a valid latitude with exactly 8 digits after the decimal.'
                ).show();
                isValid = false;
            }

            // Validate Longitude
            var longitude = $('#longitude').val();
            var longitudeRegex = /^[0-9]{1,3}(\.\d{8})$/; // Exactly 8 digits after the decimal
            if (!longitudeRegex.test(longitude)) {
                $('#longitude').addClass('is-invalid');
                $('#longitude').next('.invalid-feedback').text(
                    'Please enter a valid longitude with exactly 8 digits after the decimal.'
                ).show();
                isValid = false;
            }

            if (!isValid) {
                return; // Stop form submission if invalid
            }
            $('#createUser').prop('disabled', true);
            // If valid, proceed with AJAX submission
            $.ajax({
                url: '{{ route('employees.store') }}',
                type: 'POST',
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                success: function(response) {
                    alert('User added successfully!');
                    form[0].reset();
                    fetchEmployees();
                    form.removeClass('was-validated');
                    $('#createUser').prop('disabled', false);
                    // Remove is-invalid class from all input fields
                    form.find('.is-invalid').removeClass('is-invalid');
                    form.find('.invalid-feedback').hide(); // Hide error messages
                    $('#addUserModal').modal('hide');

                },
                error: function(xhr) {
                    $('#createUser').prop('disabled', false);
                    form.find('.invalid-feedback').hide(); // Hide previous errors
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function(field, messages) {
                            var input = $('[name="' + field + '"]');
                            input.addClass('is-invalid');
                            input.next('.invalid-feedback').text(messages[0])
                                .show();
                        });
                    }
                }
            });
        });
        // Add User functionality end

        function fetchStates() {
            $.ajax({
                url: '{{ route('fetch-states') }}', // Replace with your API endpoint
                method: 'GET',
                success: function(response) {
                    $('#stateDropdown').empty().append(
                        '<option value="" disabled selected>Select a state</option>');

                    // Populate the dropdown with states
                    $.each(response, function(index, state) {
                        $('#stateDropdown').append('<option value="' + state + '">' + state +
                            '</option>');
                    });
                },
                error: function(xhr) {
                    alert('An error occurred while fetching states.');
                }
            });
        }
        // Edit User Form Submit
        $('#editUserForm').submit(function(e) {
            e.preventDefault();
            let id = $('#edit_emp_id').val();
            $.ajax({
                url: `/employees/${id}`,
                type: 'PUT',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert("User Updated Successfully");
                    $('#editUserModal').modal('hide');
                    fetchEmployees();
                }
            });
        });

        // Clear modal content on close
        $('.modal').on('hidden.bs.modal', function() {
            // $(this).find('form')[0].reset();
            $('#viewContent').html('');
        });
    </script>
</x-app-layout>
