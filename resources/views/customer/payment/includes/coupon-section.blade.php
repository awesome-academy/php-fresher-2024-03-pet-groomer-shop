<div class=" flex flex-col flex-wrap md:grid grid-cols-12 gap-4 mt-3">
    <div class="col-span-6">
        <x-label for="coupon_code" :value="__('coupon.code')" />

        <x-input id="coupon_code" class="block mt-1 w-full" type="text" name="coupon_code" :value="old('coupon_code')" autofocus />

        <p id="coupon_text" class="text-base">
        </p>
    </div>

</div>
