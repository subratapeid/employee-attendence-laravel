<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Roles') }}
            </h2>
            @can('Edit Roles')
                <a href="{{ route('roles.create') }}" class="btn btn-primary">Create</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm">
                {{-- <x-message></x-message> --}}
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Roles</th>
                                <th scope="col">Has Permissions</th>
                                <th scope="col">Created At</th>
                                @canany(['Delete Roles', 'Edit Roles'])
                                    <th scope="col">Actions</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @if ($roles->isNotEmpty())
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->permissions->pluck('name')->implode(', ') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($role->created_at)->format('d-M-Y') }}</td>
                                        {{-- @canany(['Delete Roles', 'Edit Roles'])
                                    <td>
                                    @can('Edit Roles')
                                        <a href="{{route('roles.edit',$role->id)}}" class="btn btn-warning btn-sm">Edit</a>
                                    @endcan
                                    @can('Delete Roles')
                                        <button class="btn btn-danger btn-sm" onclick="deleteRole({{$role->id}})">Delete</button>
                                    @endcan
                                    </td>
                                @endcanany --}}
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

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
