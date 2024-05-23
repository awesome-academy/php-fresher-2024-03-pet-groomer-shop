<h3 class="text-xl text-bold mt-10 mb-4">
    {{ __('payment.summary') }}
</h3>
<div class="md:grid grid-cols-12 flex flex-wrap">
    <div class="col-span-4">
        <div class="text-base font-medium mb-6">
            {{ trans('payment.method') }}
        </div>
        <div class="flex flex-col gap-10">
            <div>
                <div class="flex items-center gap-4">
                    <x-input id="cod" checked value="cod" class="block" type="radio" name="payment_method" />
                    <x-icon.cod class="w-7 h-7 fill-current text-gray-500" />
                    <x-label for="cod" class="text-sm" :value="__('payment.cod')">

                    </x-label>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-4">
                    <x-input id="banking" checked value="banking" class="block" type="radio"
                        name="payment_method" />
                    <x-icon.banking class="w-9 h-12 fill-current text-gray-500" />
                    <x-label for="banking" class="text-sm" :value="__('payment.banking')" />
                </div>
            </div>
            <x-input id="totalPriceOriginal"  value="{{ $totalPrice }}" class="block" type="hidden" name="totalPriceOriginal" />


        </div>

    </div>
    <div class="col-span-8">
        @include('customer.payment.includes.summary-table')
    </div>
</div>
