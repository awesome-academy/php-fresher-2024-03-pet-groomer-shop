<div>
    <form class=" flex flex-wrap md:grid grid-cols-12 gap-4 my-4 mb-10" action="{{ route('care-order-history.index') }}"
        method="GET">
        <h2 class="col-span-12 font-bold text-xl">
            {{ __('Search') }}
        </h2>
        <div class="col-span-6">
            <x-label for="pet_id" :value="__('Pet')" />

            <x-select :options='$petOptions' id="pet_id" :selected="$oldInput['pet_id'] ?? ''" class="block mt-1 w-full" type="text"
                name="pet_id" autofocus />
        </div>

        <div class="col-span-6">
            <x-label for="created_at" :value="__('Created At')" />

            <x-input id="created_at" type="date" :value="$oldInput['created_at'] ?? ''" class="block mt-1 w-full" name="created_at"
                autofocus />
        </div>

        <div class="col-span-12 flex w-full justify-end">
            <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
        </div>
    </form>
</div>
