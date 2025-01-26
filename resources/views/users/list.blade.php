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
                    <a href="{{ route('users.create') }}" class="btn btn-primary w-100 w-md-auto">+ Create</a>
                </div>
            </div>
        </div>

        <div class="table-responsive " style="min-height: 250px;">
            <table class="table table-striped table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th scope="col">Sl</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Created At</th>
                        @canany(['Delete Users', 'Edit Users'])
                            <th scope="col">Actions</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @if ($users->isNotEmpty())
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->roles->pluck('name')->implode(', ') }}</td>
                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d-M-Y') }}</td>
                                @canany(['Delete Users', 'Edit Users'])
                                    <td>
                                        @can('Edit Users')
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                        @endcan
                                        @can('Delete Users')
                                            <a href="javascript:void(0);" onclick="deleteUser({{ $user->id }})"
                                                class="btn btn-danger btn-sm">Delete</a>
                                        @endcan
                                    </td>
                                @endcanany
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="mt-3">
                {{ $users->links() }}
            </div>
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
        {{-- </x-slot> --}}
</x-app-layout>
