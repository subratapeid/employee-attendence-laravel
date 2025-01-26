<x-app-layout>
    <div class="pagetitle">
        <h1>Edit Role</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <section class="section create-role">
        <div class="container-fluied ">
            <div class="card shadow-sm p-lg-4 p-sm-2">
                <div class="card-body">
                    <form action="{{ route('roles.update', $role->id) }}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Edit Role Name</label>
                                <input type="text" name="name" value="{{ old('name', $role->name) }}"
                                    id="name" class="form-control" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                        <div class="row">
                            @if ($permissions->isNotEmpty())
                                @foreach ($permissions as $permission)
                                    <div class="col-md-3 mb-3">
                                        <div class="form-check">
                                            <input {{ $hasPermissions->contains($permission->name) ? 'checked' : '' }}
                                                type="checkbox" class="form-check-input" id="{{ $permission->id }}"
                                                name="permission[]" value="{{ $permission->name }}">
                                            <label class="form-check-label"
                                                for="{{ $permission->id }}">{{ $permission->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
</x-app-layout>
