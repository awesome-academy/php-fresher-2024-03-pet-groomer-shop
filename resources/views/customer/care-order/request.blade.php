<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            <x-breadcrumb :items="$breadcrumbItems" />
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">

                <form method="POST" action="{{ route('care-order.request', ['pet' => $pet->pet_id]) }}"
                    class="p-6 bg-white border-b border-gray-200">
                    <x-display-infor />
                    @csrf
                    @include('customer.care-order.includes.pet-information')
                    <div class="my-10">
                        @include('customer.care-order.includes.pet-service')
                    </div>
                    <div class=" flex items-center gap-4">
                        <div class="flex w-5 h-5">
                            <x-input id="use-hotel" class="block mt-1 w-full" type="checkbox" name="use-hotel"
                                :value="old('use-hotel')" autofocus />
                        </div>
                        <x-label for="use-hotel" :value="__('hotel-service.use')" />
                    </div>
                    <div id="hotel-service-show" class="my-10 hidden">
                        @include('customer.care-order.includes.hotel-service')
                    </div>
                    <div>
                        @include('customer.care-order.includes.order-footer')
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary my-4">
                            {{ __('care-order.request') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-customer-layout>
