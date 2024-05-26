<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            <x-breadcrumb :items="$breadcrumbItems" />
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-3xl font-semibold my-3 mb-8 text-center">
                        {{ __('care-order.detail_for') . ' ' . $careOrder->pet->pet_name }}
                    </h1>
                    <h4 class="text-center {{ orderStatusColor($careOrder->order_status_id) }}">
                        {{ trans('care-order.status') }}: <span>{{ $careOrder->order_status_name }}</span>
                    </h4>
                    <div class="flex flex-wrap justify-between items-center">
                        <div class="flex items-center gap-5">
                            @if ($careOrder->pet->image->image_path ?? false)
                                <img class="w-36 h-36 my-4 rounded-md shadow-sm"
                                    src="{{ asset('storage/' . $pet->image->image_path) }}" alt="pet_avatar">
                            @else
                            @endif
                            <div>
                                <div class="my-3 font-medium text-gray-900">
                                    ⚖{{ trans('Pet Weight') }} : {{ $careOrder->pet->weight_name }}
                                </div>
                                <div class="my-3 font-medium text-gray-900">
                                    🎂{{ trans('Pet Birthdate') }} : {{ formatDate($careOrder->pet->pet_birthdate) }}
                                </div>
                            </div>

                        </div>
                        <div>
                            {{ trans('employee.assigned') }}:
                            <a class="text-blue-500 hover:text-blue-700"
                                href="{{ route('user.show', ['user' => $careOrder->assignTask->first()->user_id ?? '-1']) }}">
                                {{ $careOrder->assignTask->first()->full_name ?? 'N/A' }}
                            </a>
                        </div>
                    </div>


                    <hr>

                    <h3 class="text-xl text-bold mt-10 mb-4">
                        {{ __('pet-service.pet_service') }}
                    </h3>
                    <div class="relative overflow-x-auto ">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        {{ trans('pet-service.name') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ trans('pet-service-price.price') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($careOrder->petServices as $petService)
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                            {{ $petService->pet_service_name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ formatNumber($careOrder->careOrderDetail->where('pet_service_id', $petService->pet_service_id)->first()->pivot->pet_service_price, 'VND') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                            <i>{{ __('pet-service.not_found') }}</i>
                                        </th>

                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="flex gap-3 mt-4 flex-wrap justify-end">
                        <div>
                            {{ trans('pet-service.total') }} : {{ formatNumber($petServicePrice, 'VND') }}
                        </div>


                    </div>

                    <h3 class="text-xl text-bold mt-10 mb-4">
                        {{ __('hotel-service.hotel_service') }}
                    </h3>
                    <div class="  flex md:grid grid-cols-12 flex-wrap gap-5 ">
                        @if (isset($careOrder->hotelService['from_datetime']) && isset($careOrder->hotelService['to_datetime']))
                            <div class="col-span-6">
                                <x-label for="from_datetime" :value="__('From Time')" />
                                <x-input id="from_datetime" disabled :value="$careOrder->hotelService['from_datetime']" class="block mt-1 w-full"
                                    type="datetime-local" name="from_datetime" />
                            </div>
                            <div class="col-span-6">
                                <x-label for="to_datetime" :value="__('To Time')" />
                                <x-input id="to_datetime" disabled :value="$careOrder->hotelService['to_datetime']" class="block mt-1 w-full"
                                    type="datetime-local" name="to_datetime" />
                            </div>
                            <div class="col-span-12">
                                <div class="flex gap-3 mb-5 justify-end flex-wrap">
                                    <div>
                                        {{ trans('hotel-service.price') }} :
                                        {{ formatNumber($careOrder->hotelService->hotel_price, 'VND') }}
                                    </div>

                                </div>
                            </div>
                        @else
                            <i class="col-span-12">{{ __('hotel-service.not_found') }}</i>
                        @endif
                    </div>
                    @if (isset($careOrder->coupon->coupon_name))
                        <h3 class=" mb-4 text-right">
                            {{ trans('coupon.coupon') }} : {{ $careOrder->coupon->format_coupon_price }}
                        </h3>
                    @endif
                    <h3 class="text-xl text-bold mb-8 text-right">
                        {{ trans('care-order.total_price') }} : {{ $careOrder->total_price_format }}
                    </h3>


                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
