<x-app-layout>
    <div class="pagetitle">
        <h1>Create Holiday</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Holidays</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
    </div>
    <section class="section create-role">
        <div class="container-fluied ">
            <div class="card shadow-sm p-lg-4 p-sm-2">
                <div class="card-body p-4">
                    <form action="{{ route('permissions.store') }}" method="post">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        id="permission_name" class="form-control" placeholder="Enter Permission Name" />
                                    <label for="permission_name">Enter Holiday Name</label>
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
    </section>
</x-app-layout>
