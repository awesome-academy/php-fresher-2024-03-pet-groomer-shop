@php
    $activeMenu = \App\Enums\StatusEnum::getTranslated();
    $ADMIN = \App\Enums\RoleEnum::ADMIN;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('coupon.coupon') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6  border-b ">
                    <a href="{{ route('coupon.create') }}">
                        <button class="btn btn-sm btn-primary mb-5">{{ __('coupon.create') }}</button></a>
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <x-alert-session />
                    <table class="min-w-full text-left text-sm font-light text-surface ">
                        <thead class="border-b  font-medium ">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">{{ __('coupon.name') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('coupon.code') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('coupon.price') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('coupon.current_number') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('coupon.max_number') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('coupon.expiry_date') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('coupon.is_active') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($coupons as $coupon)
                                <tr class="border-b  ">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $coupon->coupon_id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $coupon->coupon_name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $coupon->coupon_code }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ formatNumber($coupon->coupon_price, 'VND') }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $coupon->current_number }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $coupon->max_number }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ formatDate($coupon->expiry_date, 'd-m-Y H:i:s') }}</td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 {{ $coupon->is_active ? ' text-green-500' : ' text-red-500' }}">
                                        {{ $coupon->is_active_name }}</td>


                                    <td class="whitespace-nowrap flex gap-3 px-6 py-4">

                                        <a href="{{ route('coupon.edit', ['coupon' => $coupon->coupon_id]) }}">
                                            <button type="submit" class="btn btn-success">
                                                {{ __('Update') }}
                                            </button>
                                        </a>

                                        <button type="button" data-id={{ $coupon->coupon_id }}
                                            class="btn btn-danger delete-coupon-btn">
                                            {{ __('Delete') }}
                                        </button>

                                    </td>

                                </tr>
                            @empty
                                @if (count($coupons) == 0)
                                    <h4 class="text-center italic">{{ __('role.not_found') }}</h4>
                                @endif
                            @endforelse

                        </tbody>

                    </table>


                    <div class="mt-4">
                        {{ $coupons->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
