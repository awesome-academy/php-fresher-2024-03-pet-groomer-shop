<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            <x-breadcrumb :items="$breadcrumbItems" />
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-alert-session />
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="POST" class="w-full flex flex-col md:grid grid-cols-12 ga-2 md:gap-4"
                        action="{{ route('pet-service.store') }}">
                        @csrf

                        <div class="col-span-6">
                            <x-label required for="pet_service_name" :value="__('pet-service.name')" />

                            <x-input id="pet_service_name" class="block mt-1 w-full" type="text"
                                name="pet_service_name" :value="old('pet_service_name')" required autofocus />
                        </div>

                        <div class="col-span-6">
                            <x-label for="pet_service_description" :value="__('pet-service.description')" />

                            <x-textarea id="pet_service_description" class="block mt-1 w-full"
                                name="pet_service_description" :value="old('pet_service_description')" />
                        </div>


                        <div class="col-span-12 flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Create') }}
                            </x-button>
                        </div>
                </div>

                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
