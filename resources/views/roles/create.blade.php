<x-app-layout>
    <div class="pagetitle">
        <h1>Create Roles</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
    </div>
    <section class="section create-role">
        <div class="container-fluied ">
            <div class="card shadow-sm p-lg-4 p-sm-2">
                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="name" value="{{ old('name') }}" id="role_name"
                                        class="form-control" placeholder="Enter Role Name" />
                                    <label for="role_name">Enter Role Name</label>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Create</button>
                            </div>
                        </div>

                        <div class="row">
                            @if ($permissions->isNotEmpty())
                                @foreach ($permissions as $permission)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="{{ $permission->id }}"
                                                name="permission[]" value="{{ $permission->name }}">
                                            <label class="form-check-label" for="{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
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
