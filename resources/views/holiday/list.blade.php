<x-app-layout>
    <div class="pagetitle">
        <h1>All Holidays</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Holidays</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard bg-white mt-4" style="min-height: 400px;">
        <div class="mb-3">
            <div class="row g-2 align-items-between justify-content-between ps-md-4 pe-md-4 pt-2">
                <!-- Search Box (8 columns) -->
                <div class="col-8 col-md-6">
                    <form method="GET" action="{{ route('employees.index') }}" class="d-flex">
                        <div class="input-group" style="max-width: 100%;">
                            <input type="text" name="search" class="form-control" placeholder="Search..."
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>

                <!-- Create Button (4 columns) -->
                <div class="col-4 col-md-2 text-md-end">
                    <a href="{{ route('holiday.create') }}" class="btn btn-primary w-100 w-md-auto">+ Create</a>
                </div>
            </div>
        </div>

        <div class="table-responsive " style="min-height: 250px;">
            <table class="table table-striped table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th>Sl</th>
                        <th>Holiday Date</th>
                        <th>Reason</th>
                        <th>State</th>
                        <th>Created At</th>
                        @canany(['delete-holiday', 'etit-holiday'])
                            <th>Actions</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @if ($holidays->isNotEmpty())
                        @foreach ($holidays as $holiday)
                            <tr>
                                <td>{{ $holiday->id }}</td>
                                <td>{{ $holiday->leave_date }}</td>
                                <td>{{ $holiday->reason }}</td>
                                <td>{{ $holiday->state }}</td>
                                <td>{{ \Carbon\Carbon::parse($holiday->created_at)->format('d-M-Y') }}
                                </td>
                                @canany(['delete-holiday', 'edit-holiday'])
                                    <td>
                                        @can('edit-holiday')
                                            <a href="{{ route('holiday.edit', $holiday->id) }}" class="btn btn-primary">Edit</a>
                                        @endcan
                                        @can('delete-holiday')
                                            <button type="button" class="btn btn-danger"
                                                onclick="deletePermission({{ $holiday->id }})">Delete</button>
                                        @endcan
                                    </td>
                                @endcanany
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{-- {{ $permissions->links() }} --}}
                {{ $holidays->appends(request()->input())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </section>
    {{-- Model Popup Part --}}
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
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" required>
                                <div class="invalid-feedback">Please enter a name.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Emp Id</label>
                                <input type="text" class="form-control" name="empId" required>
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

    {{-- <x-slot name="script"> --}}
    <script>
        function deleteUser(id) {
            if (confirm('Are you sure you want to delete?')) {
                $.ajax({
                    url: '{{ route('users.delete') }}',
                    type: 'DELETE',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);
                        window.location.href = '{{ route('users.index') }}';
                    }
                })
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            // Open Add Employee Modal
            $('.add-btn').click(function() {
                $('#addEmployeeModal').modal('show');
                // $('#addEmployeeForm')[0].reset();
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

            // // Add Employee Form Submit
            // $('#addEmployeeForm').submit(function(e) {
            //     e.preventDefault();

            //     $.ajax({
            //         url: "{{ route('employees.store') }}",
            //         type: "POST",
            //         data: $(this).serialize(),
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            //         success: function(response) {
            //             alert(response.success);
            //             location.reload();
            //         },
            //         error: function(xhr) {
            //             alert("Something went wrong. Please try again.");
            //             console.log(xhr.responseText);
            //         }
            //     });
            // });



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

            $('#addEmployeeForm').on('submit', function(e) {
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

                // If valid, proceed with AJAX submission
                $.ajax({
                    url: '{{ route('employees.store') }}',
                    type: 'POST',
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(response) {
                        alert('Employee added successfully!');
                        form[0].reset();
                        $('#addEmployeeModal').modal('hide');
                        location.reload();
                        form.removeClass('was-validated');
                    },
                    error: function(xhr) {
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
            // Add employee functionality end

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
                // $(this).find('form')[0].reset();
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
    <script>
        function deletePermission(id) {
            if (confirm('Are You sure You want to Delete?')) {
                $.ajax({
                    url: '{{ route('holiday.delete') }}',
                    type: 'delete',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    headers: {
                        'x-csrf-token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);
                        window.location.href = '{{ route('holiday.index') }}';
                    }
                })
            }
        }
    </script>

</x-app-layout>
