<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('care-order.history') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('care-order.index') }}">
                        <button class="btn btn-sm btn-primary mb-5">
                            {{ __('Go to page :page', ['page' => trans('care-order.care-order')]) }}
                        </button></a>
                    <x-display-infor />
                    @include('customer.care-order-history.includes.search')
                    @forelse ($careOrders as $careOrder)
                        <div class="p-6 my-8 shadow-xl rounded">
                            <div class="flex flex-wrap justify-between">

                                <div class="flex flex-wrap items-center my-3 gap-5">
                                    <h1 class="text-gray-800 text-xl font-semibold">
                                        #{{ trans('care-order.number') }} : {{ $careOrder->order_id }}
                                    </h1>
                                    <div>
                                        {{ trans('care-order.received_date') }} :
                                        {{ formatDate($careOrder->order_received_date, 'd/m/Y H:i') }}
                                    </div>
                                </div>

                                <div>
                                    @include('customer.care-order-history.includes.dropdown-setting')
                                </div>
                            </div>
                            <div class="mb-3">
                                {{ trans('order.status') }} : <span id="order_status_{{ $careOrder->order_id }}"
                                    class="{{ orderStatusColor($careOrder->order_status) }} ">
                                    {{ $careOrder->order_status_name }}
                                </span>
                            </div>

                            <div>
                                {{ trans('Pet') }}: {{ $careOrder->pet->pet_name }}
                            </div>
                            <div class="my-3">
                                {{ trans('care-order.total_price') }}: {{ $careOrder->total_price_format }}
                            </div>

                        </div>
                    @empty
                        <h4 class="text-center italic">{{ __('care-order.not_found') }}</h4>
                    @endforelse


                    <div class="mt-3">
                        {{ $careOrders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
