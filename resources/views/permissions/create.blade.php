<x-app-layout>
    {{-- <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold text-dark h4">
                {{ __('Permissions/Create') }}
            </h2>
            <a href="{{ route('permissions.index') }}" class="btn btn-primary">Back</a>
        </div>
    </x-slot> --}}
    <div class="pagetitle">
        <h1>All Employees</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Employees</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard bg-white mt-4" style="min-height: 400px;">
        <div class="py-5 d-flex justify-content-center">
            <div class="container">
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body p-4">
                        <form action="{{ route('permissions.store') }}" method="post">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            id="permission_name" class="form-control"
                                            placeholder="Enter Permission Name" />
                                        <label for="permission_name">Enter Permission Name</label>
                                        @error('name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="submit" class="btn btn-success w-100">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
