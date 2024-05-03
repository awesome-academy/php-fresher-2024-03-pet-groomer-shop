@php

    $breadcrumbItems = [
        ['text' => trans('Role'), 'url' => route('role.index')],
        ['text' => trans('role.create'), 'url' => route('role.create')],
    ];
@endphp

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
                        action="{{ route('role.store') }}">
                        @csrf
                        <div class="col-span-12">

                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        </div>

                        <!-- First Name -->
                        <div class="col-span-6">
                            <x-label for="role_name" required :value="__('role.name')" />

                            <x-input id="role_name" class="block mt-1 w-full" type="text" name="role_name"
                                :value="old('role_name')" required autofocus />
                        </div>

                        <div class="col-span-12 flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Create') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
