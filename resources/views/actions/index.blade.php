<x-app-layout>
    <div id="loading-spinner" class="spinner-overlay" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles/Create') }}
            </h2>
            <a href="{{ route('roles.index') }}"
                class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Back</a>
        </div>
    </x-slot>


    <div class="container">
        <h2>Actions</h2>
        <a href="{{ route('actions.create') }}" class="btn btn-primary mb-3">Add New Action</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Action Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($actions as $action)
                    <tr>
                        <td>{{ $action->id }}</td>
                        <td>{{ $action->name }}</td>
                        <td>
                            <a href="{{ route('actions.edit', $action) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('actions.destroy', $action) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-app-layout>
