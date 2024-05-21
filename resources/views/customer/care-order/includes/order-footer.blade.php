<hr class="my-4">
<div class=" flex flex-col flex-wrap md:grid grid-cols-12 gap-4">

    <div class="col-span-6">
        <x-label required for="branch_id" :value="__('Branch')" />

        <x-select id="branch_id" class="block mt-1 w-full" name="branch_id" :options='$branches' required autofocus />
    </div>

    <div class="col-span-6">
        <x-label for="order_note" :value="__('order.note')" />

        <x-textarea id="order_note" class="block mt-1 w-full" name="order_note" :value="old('order_note')"
            autofocus />
    </div>

</div>
