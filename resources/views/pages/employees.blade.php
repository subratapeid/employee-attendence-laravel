<x-app-layout>
    <div class="pagetitle">
        <h1>All Employees</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Employees</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard bg-white mt-4 min-vh-100">
        <div class="mb-3">
            <div class="row g-2">
                <!-- Buttons Section (Mobile View) -->
                <div class="col-12 d-flex d-md-none">
                    <button class="btn btn-primary flex-fill me-2 add-btn">Add Employee</button>
                    <a href="{{ route('employees.export', request()->all()) }}"
                        class="btn btn-secondary export-btn">Export</a>
                </div>

                <!-- Filter and Search Section (Mobile & Desktop) -->
                <div class="col-12 col-md-6 pt-2">
                    <form method="GET" action="{{ route('employees.index') }}"
                        class="d-flex flex-column flex-md-row gap-2">
                        <div class="d-flex w-100 flex-row gap-2 align-items-center">
                            <select name="filter" class="form-select" style="max-width: 150px; flex-shrink: 0;">
                                <option value="">Select Filter</option>
                                <option value="department" {{ request('filter') == 'department' ? 'selected' : '' }}>
                                    Department
                                </option>
                                <option value="designation" {{ request('filter') == 'designation' ? 'selected' : '' }}>
                                    Designation
                                </option>
                            </select>
                            <div class="input-group flex-grow-1">
                                <input type="text" name="search" class="form-control" placeholder="Search..."
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>


                <!-- Buttons Section (Desktop View) -->
                <div class="col-12 col-md-6 text-md-end d-none d-md-block">
                    <button class="btn btn-primary me-2 add-btn">Add Employee</button>
                    <a href="{{ route('employees.export', request()->all()) }}"
                        class="btn btn-secondary export-btn">Export</a>
                </div>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th class="text-nowrap">SL No</th>
                        <th class="text-nowrap">Name</th>
                        <th class="text-nowrap">Emp ID</th>
                        <th class="text-nowrap">Email</th>
                        <th class="text-nowrap">Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $index => $employee)
                        <tr>
                            <td class="text-nowrap">{{ $sl_no + $index }}</td>
                            <td class="text-nowrap">{{ $employee->name }}</td>
                            <td class="text-nowrap">{{ $employee->id }}</td>
                            <td class="text-nowrap">{{ $employee->email }}</td>
                            <td class="text-nowrap">
                                <button class="btn btn-warning btn-sm edit-btn"
                                    data-id="{{ $employee->id }}">Edit</button>
                                <button class="btn btn-danger btn-sm delete-btn"
                                    data-id="{{ $employee->id }}">Delete</button>
                                <button class="btn btn-info btn-sm view-btn"
                                    data-id="{{ $employee->id }}">View</button>
                                <button class="btn btn-secondary btn-sm reset-btn" data-id="{{ $employee->id }}">Reset
                                    Password</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $employees->appends(request()->input())->links('pagination::bootstrap-5') }}
        </div>
    </section>

    <!-- Add Employee Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addEmployeeForm">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Employee</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Employee Modal -->
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editEmployeeForm">
                        <input type="hidden" id="edit_emp_id">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Employee</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Employee Modal -->
    <div class="modal fade" id="viewEmployeeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Employee Details</h5>
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



    <script>
        $(document).ready(function() {
            // Open Add Employee Modal
            $('.add-btn').click(function() {
                $('#addEmployeeModal').modal('show');
                $('#addEmployeeForm')[0].reset();
            });

            // Open Edit Employee Modal
            $('.edit-btn').click(function() {
                let empId = $(this).data('id');
                $('#editEmployeeModal').modal('show');
                $.get(`/employee/${empId}`, function(data) {
                    $('#edit_emp_id').val(data.id);
                    $('#edit_name').val(data.name);
                    $('#edit_email').val(data.email);
                });
            });

            // Open View Employee Modal
            $('.view-btn').click(function() {
                let empId = $(this).data('id');
                $('#viewEmployeeModal').modal('show');
                $.get(`/employee/${empId}`, function(data) {
                    $('#view_photo').attr('src', data.photo);
                    $('#view_name').text(data.name);
                    $('#view_email').text(data.email);
                    $('#view_phone').text(data.phone);
                    $('#view_department').text(data.department);
                });
            });

            // Add Employee Form Submit
            $('#addEmployeeForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('employees.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.success);
                        location.reload();
                    },
                    error: function(xhr) {
                        alert("Something went wrong. Please try again.");
                        console.log(xhr.responseText);
                    }
                });
            });


            // Edit Employee Form Submit
            $('#editEmployeeForm').submit(function(e) {
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
                        alert(response.success);
                        location.reload();
                    }
                });
            });

            // Clear modal content on close
            $('.modal').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $('#viewContent').html('');
            });


            // Delete Employee
            $('.delete-btn').click(function() {
                if (confirm("Are you sure you want to delete this employee?")) {
                    let empId = $(this).data('id');
                    $.ajax({
                        url: `/employees/${empId}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            alert(response.success);
                            location.reload();
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
                        alert(response.success + '\nNew Password: ' + response.new_password);
                    }).fail(function() {
                        alert('Failed to reset password.');
                    });
                }
            });
        });
    </script>

</x-app-layout>
