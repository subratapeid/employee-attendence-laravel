<x-app-layout>
    <div class="pagetitle">
        <h1>All Permissions</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Permissions</li>
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
                    <a href="{{ route('permissions.create') }}" class="btn btn-primary w-100 w-md-auto">+ Create</a>
                </div>
            </div>
        </div>

        <div class="table-responsive " style="min-height: 250px;">
            <table class="table table-striped table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th>Sl</th>
                        <th>Permissions</th>
                        <th>Created At</th>
                        @canany(['Delete Permissions', 'Edit Permissions'])
                            <th>Actions</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @if ($permissions->isNotEmpty())
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $permission->id }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($permission->created_at)->format('d-M-Y') }}
                                </td>
                                @canany(['Delete Permissions', 'Edit Permissions'])
                                    <td>
                                        @can('Edit Permissions')
                                            <a href="{{ route('permissions.edit', $permission->id) }}"
                                                class="btn btn-primary">Edit</a>
                                        @endcan
                                        @can('Delete Permissions')
                                            <button type="button" class="btn btn-danger"
                                                onclick="deletePermission({{ $permission->id }})">Delete</button>
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
                {{ $permissions->appends(request()->input())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </section>

    <script>
        function deletePermission(id) {
            if (confirm('Are You sure You want to Delete?')) {
                $.ajax({
                    url: '{{ route('permissions.delete') }}',
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
                        window.location.href = '{{ route('permissions.index') }}';
                    }
                })
            }
        }
    </script>

</x-app-layout>
