<div class="overflow-x-auto">
    <table class="table-auto min-w-full">
        <thead>
            <tr>
                <th class=" py-2">{{ trans('pet-service.total') }}</th>
                <th class=" py-2">{{ trans('hotel-service.price') }}</th>
                <th class=" py-2">{{ trans('coupon.price') }}</th>
                <th class=" py-2 text-xl">{{ trans('payment.total') }}</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border px-4 py-2">
                    <i>

                        {{ formatNumber($petServices[1], 'VND') }}
                    </i>
                </td>
                <td class="border px-4 py-2">
                    <i>

                        {{ formatNumber($hotel[0], 'VND') }}
                    </i>
                </td>
                <td class="border px-4 py-2">
                    <i>
                        <span id="coupon_price">
                            0
                        </span>
                        VND
                    </i>
                </td>
                <td class="border px-4 py-2 font-bold">
                    <i>
                        <span id="totalPrice">
                            {{ formatNumber($totalPrice) }}
                        </span>
                        VND
                    </i>

                </td>
            </tr>

        </tbody>
    </table>
</div>
