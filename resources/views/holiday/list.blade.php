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
            <div class="row g-2 align-items-center justify-content-end ps-md-4 pe-md-4 pt-2">
                <!-- Search Box (8 columns) -->
                {{-- <div class="col-8 col-md-6">
                    <form method="GET" action="{{ route('employees.index') }}" class="d-flex">
                        <div class="input-group" style="max-width: 100%;">
                            <input type="text" name="search" class="form-control" placeholder="Search..."
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div> --}}

                <!-- Create Button (4 columns) -->
                {{-- <div class="col-4 col-md-2 text-md-end">
                    <a href="{{ route('holiday.create') }}" class="btn btn-primary w-100 w-md-auto">+ Create</a>
                </div> --}}
                <!-- Button to trigger the modal -->
                <button type="button" class="col-4 col-md-2 btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#holidayModal">
                    Add Holiday
                </button>
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
                                                onclick="deleteHoliday({{ $holiday->id }})">Delete</button>
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


    <!-- Modal -->
    <div class="modal fade" id="holidayModal" tabindex="-1" aria-labelledby="holidayModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="holidayModalLabel">Add Holiday</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="holidayForm">
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="holiday_date" class="form-label">Holiday Date</label>
                                <input type="date" class="form-control" id="holiday_date" name="holiday_date"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="state" class="form-label">Select State</label>
                                <select class="form-select" id="state" name="state" required>
                                    <option value="" selected disabled>Loading states...</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason</label>
                            <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Enter holiday reason"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="holidayForm">Create</button>
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
        $(document).ready(function() {
            // Fetch states from the server when modal is opened
            $('#holidayModal').on('show.bs.modal', function() {
                $.ajax({
                    url: '{{ route('fetch-states') }}', // Adjust this route as necessary
                    method: 'GET',
                    success: function(response) {
                        let stateDropdown = $('#state');
                        stateDropdown.empty();

                        // Add the "All States" option
                        stateDropdown.append(
                            '<option value="All States" selected>All States</option>');

                        // Loop through API response and add states
                        $.each(response, function(index, state) {
                            stateDropdown.append(
                                `<option value="${state}">${state}</option>`);
                        });
                    },
                    error: function() {
                        alert('Failed to load states');
                    }
                });
            });




            // Handle form submission using AJAX
            $('#holidayForm').on('submit', function(e) {
                e.preventDefault();

                // Clear previous errors
                $('.text-danger').remove();

                let formData = {
                    holiday_date: $('#holiday_date').val(),
                    state: $('#state').val(),
                    reason: $('#reason').val(),
                    _token: '{{ csrf_token() }}' // Laravel CSRF token for security
                };

                $.ajax({
                    url: '{{ route('holiday.store') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            $('#holidayForm')[0].reset();
                            $('#holidayModal').modal('hide');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        console.log(errors);

                        // Show errors in respective fields
                        if (errors.holiday_date) {
                            $('#holiday_date').after('<div class="text-danger">' + errors
                                .holiday_date[0] + '</div>');
                        }
                        if (errors.state) {
                            $('#state').after('<div class="text-danger">' + errors.state[0] +
                                '</div>');
                        }
                        if (errors.reason) {
                            $('#reason').after('<div class="text-danger">' + errors.reason[
                                0] + '</div>');
                        }
                    }
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

        function deleteHoliday(id) {
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
