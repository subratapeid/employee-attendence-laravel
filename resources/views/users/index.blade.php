<x-app-layout>
    <style>
        .filter-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: red;
            color: white;
            font-size: 12px;
            border-radius: 50%;
            padding: 3px 7px;
        }

        #search-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            align-items: center;
            justify-content: center;
            color: white;
        }

        #search-overlay.active {
            display: flex;
        }

        @media (max-width: 768px) {
            .mobile-hidden {
                display: none;
            }

            .mobile-visible {
                display: flex;
            }
        }

        @media (min-width: 769px) {
            .mobile-hidden {
                display: flex;
            }

            .mobile-visible {
                display: none;
            }
        }
    </style>

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
                    <select id="department" class="form-select mb-3">
                        <option value="">All Departments</option>
                        <option value="HR">HR</option>
                        <option value="Finance">Finance</option>
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

                        <button type="submit" class="btn btn-primary">Create User</button>
                    </form>
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
            // $('#addEmployeeForm')[0].reset();
        });
        let appliedFilters = 0;

        function fetchEmployees(page = 1) {
            $('#loading-overlay').addClass('d-flex')
            let search = $('#search').val() || $('#overlaySearch').val();
            let perPage = $('#per_page').val();

            $.ajax({
                url: "{{ route('test-index') }}",
                method: 'GET',
                data: {
                    search,
                    page,
                    per_page: perPage
                },
                success: function(response) {
                    $('#loading-overlay').removeClass('d-flex')

                    let tableHtml =
                        '<div class="table-responsive" overflow-y: auto;">' +
                        '<table class="table table-striped table-bordered">' +
                        '<thead class="table-dark"><tr>' +
                        '<th>SL No</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Action</th>' +
                        '</tr></thead><tbody>';
                    response.data.forEach(function(employee) {
                        tableHtml += '<tr><td>' + employee.name + '</td>';
                        tableHtml += '<td>' + employee.email + '</td>';
                        tableHtml += '<td>' + employee.department + '</td>';
                        tableHtml += '<td>' + employee.status + '</td></tr>';
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
            appliedFilters = ($('#department').val() ? 1 : 0) + ($('#status').val() ? 1 : 0);
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
    </script>
</x-app-layout>
