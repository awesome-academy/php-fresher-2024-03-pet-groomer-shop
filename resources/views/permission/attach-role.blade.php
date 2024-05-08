<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-breadcrumb :items="$breadcrumbItems" />
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-alert-session />
                    <form method="POST"
                        class="w-full flex flex-col
                    md:grid grid-cols-12 gap-2 md:gap-4"
                        action="{{ route('permission.attach-role', ['permission' => $permission['permission_id']]) }}">
                        @csrf
                        <div class="col-span-12">

                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        </div>
                        <div class="col-span-12 flex items-center gap-2">
                            <h3 class=" font-bold">{{ __('Permission') }}:</h3>
                            <h3 class="font-semibold">
                                {{ $permission->permission_name }}
                            </h3>
                        </div>
                        @forelse ($roles as $role)
                            <div class="col-span-3">
                                <x-label :for="$role->role_name" class="font-bold" :value="$role->role_name" />

                                <x-input :id="$role->role_name" class="block mt-1  w-5" type="checkbox" name="role_id[]"
                                    value="{{ $role->role_id }}"
                                    :checked="$permission->roles()->find($role->role_id) !== null" autofocus />
                            </div>
                        @empty
                            <h3>
                                {{ __('role.not_found') }}
                            </h3>
                        @endforelse


                        <div class="col-span-12 flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
