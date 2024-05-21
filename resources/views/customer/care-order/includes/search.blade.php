<div>
    <form class=" flex flex-wrap md:grid grid-cols-12 gap-4 my-4 mb-10"
        action="{{ route('care-order.index') }}" method="GET">
        <h2 class="col-span-12 font-bold text-xl">
            {{ __('Search') }}
        </h2>
        <div class="col-span-6">
            <x-label for="pet_name" :value="__('Pet Name')" />

            <x-input id="pet_name" :value="$oldInput['pet_name'] ?? ''" class="block mt-1 w-full" type="text" name="pet_name" autofocus />
        </div>

        <div class="col-span-6">
            <x-label for="pet_type" :value="__('Pet Type')" />

            <x-select id="pet_type" :selected="$oldInput['pet_type'] ?? ''" class="block mt-1 w-full" :options="$petTypesSelectedExtra" name="pet_type"
                autofocus />
        </div>

        <div class="col-span-12 flex w-full justify-end">
            <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
        </div>
    </form>
</div>
