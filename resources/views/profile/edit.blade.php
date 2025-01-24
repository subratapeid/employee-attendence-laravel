{{-- <x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}


<x-app-layout>

    <section class="section profile min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-10 col-sm-12 d-flex flex-column align-items-center justify-content-center">

                <!-- Profile Section -->
                <div class="card mb-4 profile-card">
                    <div class="card-body">
                        <div class="mt-4">
                            <div class="max-w-xl">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Password Update Section -->
                <div class="card mb-4 profile-card">
                    <div class="card-body">
                        <div class="mt-4">
                            <div class="max-w-xl">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Deletion Section -->
                <div class="card mb-4 profile-card">
                    <div class="card-body">
                        <div class="mt-4">
                            <div class="max-w-xl">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>
                </div>

            </div>
    </section>
    </div>
</x-app-layout>
