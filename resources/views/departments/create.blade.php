<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Departments/Create') }}
            </h2>
            <a href="{{ route('roles.index') }}"
                class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Back</a>
        </div>
    </x-slot>

    <div class="py-8 justify-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('departments.store') }}" method="post">
                        @csrf
                        <div>
                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="text" name="name" value="{{ old('name') }}" id="role_name"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" " />
                                    <label for="role_name"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Enter
                                        Role Name</label>
                                    @error('name')
                                        <p class="text-red-400 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="relative z-0 w-full mb-5 group">
                                    <button type="submit"
                                        class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Create</button>
                                </div>
                            </div>
                            <div class="grid grid-cols-4">
                                @if ($permissions->isNotEmpty())
                                    @foreach ($permissions as $permission)
                                        <div class="mt-3">
                                            <input type="checkbox" class="rounded" id="{{ $permission->id }}"
                                                name="permission[]" value="{{ $permission->name }}">
                                            <label for="{{ $permission->id }}">{{ $permission->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
