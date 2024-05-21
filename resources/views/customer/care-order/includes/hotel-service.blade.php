<h2 class="my-4 text-2xl font-normal">
    {{ __('hotel-service.hotel_service') . ' :' }}
</h2>
<div class=" flex flex-col flex-wrap md:grid grid-cols-12 gap-4">

    <div class="col-span-6">
        <x-label for="from_datetime" :value="__('From Time')" />

        <x-input id="from_datetime" class="block mt-1 w-full" type="datetime-local" name="from_datetime"
            :value="old('from_datetime')" />
    </div>

    <div class="col-span-6">
        <x-label for="to_datetime" :value="__('To Time')" />

        <x-input id="to_datetime" class="block mt-1 w-full" type="datetime-local" name="to_datetime"
            :value="old('to_datetime')" />
    </div>

</div>
