<div>
    <form class=" flex flex-wrap md:grid grid-cols-12 gap-4 my-4 mb-10" action="{{ route('care-order-manage.index') }}"
        method="GET">
        <h2 class="col-span-12 font-bold text-xl">
            {{ __('Search') }}
        </h2>
        <div class="col-span-6">
            <x-label for="order_received_date" :value="__('care-order.received_date')" />

            <x-input id="order_received_date" :value="$oldInput['order_received_date'] ?? ''" class="block mt-1 w-full" type="date"
                name="order_received_date" autofocus />
        </div>

        <div class="col-span-6">
            <x-label for="branch_id" :value="__('branch.branch')" />

            <x-select id="branch_id" :selected="$oldInput['branch_id'] ?? ''" class="block mt-1 w-full" :options="$branchOptions" name="branch_id"
                autofocus />
        </div>

        <div class="col-span-6">
            <x-label for="order_status" :value="__('order.status')" />

            <x-select id="order_status" :selected="$oldInput['order_status'] ?? ''" class="block mt-1 w-full" :options="$extraOrderStatusOptions" name="order_status"
                autofocus />
        </div>

        <div class="col-span-12 flex w-full justify-end">
            <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
        </div>
    </form>
</div>
