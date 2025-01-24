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
        <h2>Create New Entity</h2>
        <form action="{{ route('entities.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Entity Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Save Entity</button>
        </form>
    </div>


</x-app-layout>
