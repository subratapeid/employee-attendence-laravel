<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-dark">
                {{ __('Roles/Edit') }}
            </h2>
            <a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
        </div>
    </x-slot>

    <div class="py-4 d-flex justify-content-center">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body text-dark">
                    <form action="{{ route('users.update', $user->id) }}" method="post">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="permission_name" class="form-label">Edit Role Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    id="permission_name" class="form-control" placeholder="Edit Role Name" />
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Edit Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    id="email" class="form-control" placeholder="Edit Email" />
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            @if ($roles->isNotEmpty())
                                @foreach ($roles as $role)
                                    <div class="col-md-3 form-check">
                                        <input {{ $hasRoles->contains($role->id) ? 'checked' : '' }} type="checkbox"
                                            class="form-check-input" id="{{ $role->id }}" name="role[]"
                                            value="{{ $role->name }}">
                                        {{-- <input type="checkbox" class="form-check-input" id="{{ $role->id }}"
                                            name="role[]" value="{{ $role->name }}"> --}}
                                        <label class="form-check-label"
                                            for="{{ $role->id }}">{{ $role->name }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
