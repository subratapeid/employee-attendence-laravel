<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Departments') }}
            </h2>
            @can('Edit Roles')
                <a href="{{ route('departments.create') }}"
                    class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Create</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7x(l mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-message></x-message>
                <div class="p-6 text-blue-900">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead
                            class="text-xs text-white uppercase bg-gray-700 dark:bg-gray-700 dark:text-gray-400 px-4">
                            <tr class="mx-4">
                                <th class="px-6 py-3">Sl</th>
                                <th class="px-6 py-3">Departments</th>
                                <th class="px-6 py-3">Has Permissions</th>
                                <th class="px-6 py-3">Created At</th>
                                @canany(['Delete Roles', 'Edit Roles'])
                                    <th class="px-6 py-3">Actions</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @if ($roles->isNotEmpty())
                                @foreach ($roles as $role)
                                    <tr class="border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-3">{{ $role->id }}</td>
                                        <td class="px-6 py-3">{{ $role->name }}</td>
                                        <td class="px-6 py-3">{{ $role->permissions->pluck('name')->implode(', ') }}
                                        </td>
                                        <td class="px-6 py-3">
                                            {{ \Carbon\Carbon::parse($role->created_at)->format('d-M-Y') }}</td>

                                        @canany(['Delete Roles', 'Edit Roles'])
                                            <td class="px-6 py-3">
                                                @can('Edit Roles')
                                                    <a href="{{ route('roles.edit', $role->id) }}"
                                                        class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-4 py-1 text-center me-2 mb-2">Edit</a>
                                                @endcan
                                                @can('Delete Roles')
                                                    <a href="javascript:void(0);" onclick="deleteRole({{ $role->id }})"
                                                        class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-4 py-1 text-center me-2 mb-2">Delete</a>
                                                @endcan
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="pagination px-2 py-4">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script" type='text/javascript'>
        <script>
            function deleteRole(id) {
                if (confirm('Are You sure You want to Delete?')) {
                    $.ajax({
                        url: '{{ route('roles.delete') }}',
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
                            window.location.href = '{{ route('roles.index') }}';
                        }
                    })
                }
            }
        </script>
    </x-slot>
</x-app-layout>
