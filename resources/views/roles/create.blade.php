<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Roles/Create') }}
            </h2>
            <a href="{{ route('roles.index') }}" class="btn btn-primary">Back</a>
        </div>
    </x-slot>

    <div class="py-4 d-flex justify-content-center">
        <div class="container">
            <div class="card shadow-sm">
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
