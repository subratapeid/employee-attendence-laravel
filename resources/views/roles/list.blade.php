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
                    <a href="{{ route('roles.create') }}" class="btn btn-primary w-100 w-md-auto">+ Create</a>
                </div>
            </div>
        </div>



        <div class="table-responsive " style="min-height: 250px;">
            <table class="table table-striped table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th class="text-nowrap" style="min-width: 50px;" scope="col">Sl</th>
                        <th class="text-nowrap" scope="col">Roles</th>
                        <th style="min-width: 500px;" scope="col">Has Permissions</th>
                        <th class="text-nowrap" scope="col">Created At</th>
                        @canany(['Delete Roles', 'Edit Roles'])
                            <th class="text-nowrap" scope="col">Actions</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @if ($roles->isNotEmpty())
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td class="text-nowrap">{{ $role->name }}</td>
                                <td>{{ $role->permissions->pluck('name')->implode(', ') }}</td>
                                <td class="text-nowrap">{{ \Carbon\Carbon::parse($role->created_at)->format('d-M-Y') }}
                                </td>
                                @canany(['Delete Roles', 'Edit Roles'])
                                    <td class="text-nowrap">
                                        @can('Edit Roles')
                                            <a href="{{ route('roles.edit', $role->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                        @endcan
                                        @can('Delete Roles')
                                            <button class="btn btn-danger btn-sm"
                                                onclick="deleteRole({{ $role->id }})">Delete</button>
                                        @endcan
                                    </td>
                                @endcanany
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="mt-4">
                {{ $roles->links() }}
            </div>
        </div>
    </section>

    {{-- <x-slot name="script">
        <script>
            function deleteRole(id){
                if(confirm('Are You sure You want to Delete?')){
                    $.ajax({
                        url: '{{route('roles.delete')}}',
                        type: 'delete',
                        data: {id:id},
                        dataType: 'json',
                        headers:{
                            'x-csrf-token': '{{csrf_token()}}'
                        },
                        success: function(response){
                            console.log(response);
                            window.location.href= '{{route('roles.index')}}';
                        }
                    })
                }
            }
        </script>
    </x-slot> --}}
</x-app-layout>
