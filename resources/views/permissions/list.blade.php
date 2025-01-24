<x-app-layout>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Permissions</h2>
                        {{-- @can('Create Permissions')
                                <a href="{{ route('permissions.create') }}" class="btn btn-primary">Create</a>
                            @endcan --}}
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Permissions</th>
                                    <th>Created At</th>
                                    {{-- @canany(['Delete Permissions', 'Edit Permissions'])
                                            <th>Actions</th>
                                        @endcanany
                                    </tr> --}}
                            </thead>
                            <tbody>
                                @if ($permissions->isNotEmpty())
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->id }}</td>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($permission->created_at)->format('d-M-Y') }}
                                            </td>
                                            {{-- @canany(['Delete Permissions', 'Edit Permissions']) --}}
                                            <td>
                                                {{-- @can('Edit Permissions') --}}
                                                {{-- <a href="{{ route('permissions.edit', $permission->id) }}"
                                                                class="btn btn-primary">Edit</a> --}}
                                                {{-- @endcan --}}
                                                {{-- @can('Delete Permissions') --}}
                                                {{-- <button type="button" class="btn btn-danger"
                                                        onclick="deletePermission({{ $permission->id }})">Delete</button> --}}
                                                {{-- @endcan --}}
                                            </td>
                                            {{-- @endcanany --}}
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
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
            function deletePermission(id) {
                if (confirm('Are You sure You want to Delete?')) {
                    $.ajax({
                        // url: '{{ route('permissions.delete') }}',
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
                            // window.location.href = '{{ route('permissions.index') }}';
                        }
                    })
                }
            }
        </script> --}}

</x-app-layout>
