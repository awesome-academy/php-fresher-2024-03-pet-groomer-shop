@php

    $breadcrumbItems = [
        ['text' => trans('coupon.coupon'), 'url' => route('coupon.index')],
        ['text' => trans('coupon.create'), 'url' => route('coupon.create')],
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
                        action="{{ route('coupon.store') }}">
                        @csrf
                        <div class="col-span-12">

                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        </div>
                        <div class="col-span-6">
                            <x-label for="coupon_name" required :value="__('coupon.name')" />

                            <x-input id="coupon_name" class="block mt-1 w-full" type="text" name="coupon_name"
                                :value="old('coupon_name')" required autofocus />
                        </div>
                        <div class="col-span-6">
                            <x-label for="coupon_price" required :value="__('coupon.price')" />

                            <x-input id="coupon_price" class="block mt-1 w-full" type="number" name="coupon_price"
                                :value="old('coupon_price')" required autofocus />
                        </div>

                        <div class="col-span-6">
                            <div class="flex items-center gap-4">
                                <x-label for="coupon_code" required :value="__('coupon.code')" />
                                <x-icon.generate class="w-5 h-5 mb-2 cursor-pointer" id="generate-icon" />
                            </div>


                            <x-input id="coupon_code" class="block mt-1 w-full" type="text" name="coupon_code"
                                :value="old('coupon_code')" required autofocus />
                        </div>


                        <div class="col-span-6">
                            <x-label for="expiry_date" required :value="__('coupon.expiry_date')" />

                            <x-input id="expiry_date" class="block mt-1 w-full" type="datetime-local" name="expiry_date"
                                :value="old('expiry_date')" required autofocus />
                        </div>
                        <div class="col-span-6">
                            <x-label for="current_number" required :value="__('coupon.current_number')" />

                            <x-input id="current_number" value="0" class="block mt-1 w-full" type="number"
                                name="current_number" :value="old('current_number')" required autofocus />
                        </div>

                        <div class="col-span-6">
                            <x-label for="max_number" required :value="__('coupon.max_number')" />

                            <x-input id="max_number" :value="{{ 1000 }}" class="block mt-1 w-full" type="number"
                                name="max_number" :value="old('max_number')" required autofocus />
                        </div>

                        <div class="col-span-6">
                            <x-label class="mb-4" required for="is_active" :value="__('Is Active')" />
                            <div class="flex w-5 h-5">
                                <x-input id="is_active" class="block mt-1 w-full" type="checkbox" name="is_active"
                                    :value="old('is_active')" />
                            </div>

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
