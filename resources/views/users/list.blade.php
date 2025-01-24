<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Users') }}
            </h2>
            {{-- @can('Create Users')
            <a href="{{route('users.create')}}" class="btn btn-primary">Create</a>
            @endcan --}}
        </div>
    </x-slot>

    <div class="py-4 d-flex justify-content-center">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body text-dark">

                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Created At</th>
                                {{-- @canany(['Delete Users', 'Edit Users']) --}}
                                <th scope="col">Actions</th>
                                {{-- @endcanany --}}
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
                                        {{-- @canany(['Delete Users', 'Edit Users']) --}}
                                        <td>
                                            {{-- @can('Edit Users') --}}
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            {{-- @endcan
                                    @can('Delete Users') --}}
                                            <a href="javascript:void(0);" onclick="deleteUser({{ $user->id }})"
                                                class="btn btn-danger btn-sm">Delete</a>
                                            {{-- @endcan --}}
                                        </td>
                                        {{-- @endcanany --}}
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

    {{-- <x-slot name="script">
        <script>
            function deleteUser(id){
                if(confirm('Are you sure you want to delete?')){
                    $.ajax({
                        url: '{{route('users.delete')}}',
                        type: 'DELETE',
                        data: {id: id},
                        dataType: 'json',
                        headers:{
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        success: function(response){
                            console.log(response);
                            window.location.href = '{{route('users.index')}}';
                        }
                    })
                }
            }
        </script>
    </x-slot> --}}
</x-app-layout>
