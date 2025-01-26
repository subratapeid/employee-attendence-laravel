<x-app-layout>
    <div class="pagetitle">
        <h1>Create User</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
    </div>
    <section class="section create-user">
        <div class="container-fluied ">
            <div class="card shadow-sm p-lg-4 p-sm-2">
                <div class="card-body text-dark">
                    <form action="{{ route('users.store') }}" method="post">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="role_name" class="form-label">Enter User Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" id="role_name"
                                    class="form-control" placeholder="Enter User Name" />
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Enter User Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" id="email"
                                    class="form-control" placeholder="Enter User Email" />
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-3">
                            @if ($roles->isNotEmpty())
                                @foreach ($roles as $role)
                                    <div class="col-md-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="{{ $role->id }}"
                                            name="role[]" value="{{ $role->name }}">
                                        <label class="form-check-label"
                                            for="{{ $role->id }}">{{ $role->name }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Create</button>
                        </div>
                    </form>
                </div>
            </div>
    </section>
</x-app-layout>
