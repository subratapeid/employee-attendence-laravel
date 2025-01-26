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
