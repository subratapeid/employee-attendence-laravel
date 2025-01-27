<x-app-layout>
    <div class="pagetitle">
        <h1>All Roles</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Roles</li>
            </ol>
        </nav>
    </div>
    <section class="section leave">
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
                <div class="col-4 col-md-2 text-md-end">
                    <button id="appy-leave-btn" class="btn btn-primary w-100 w-md-auto">Apply Leave</button>
                </div>
            </div>
        </div>



        <div class="table-responsive " style="min-height: 250px;">
            <table class="table table-striped table-bordered">
                <thead class="table-secondary">


                    <tr>
                        <th>SL No</th>
                        <th>Duration</th>
                        <th>Days</th>
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>Apply Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>02-11-2024 - 02-11-2024</td>
                        <td>1 Day</td>
                        <td>Personal</td>
                        <td><span class="status">Approved</span></td>
                        <td>02-11-2024</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>31-10-2024 - 02-11-2024</td>
                        <td>3 Days</td>
                        <td>Personal</td>
                        <td><span class="status">Approved</span></td>
                        <td>02-11-2024</td>
                    </tr>
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
        $('#appy-leave-btn').click(function() {
            $('#applyLeaveModal').modal('show');
            // $('#addUserForm')[0].reset();
        });
    </script>
</x-app-layout>
