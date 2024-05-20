<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            <x-breadcrumb :items="$breadcrumbItems" />
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <form id="payment-form" class="p-6 bg-white border-b border-gray-200">
                    @include('customer.payment.includes.pet-information')

                    @include('customer.payment.includes.coupon-section')

                    @include('customer.payment.includes.pet-services')

                    @include('customer.payment.includes.pet-hotel')

                    @include('customer.payment.includes.summary')

                    <div class=" my-10 flex justify-end">
                        <button class="btn btn-primary">{{ __('payment.pay') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-customer-layout>
