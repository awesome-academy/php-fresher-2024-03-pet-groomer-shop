<div>
    <form class=" flex flex-wrap md:grid grid-cols-12 gap-4 my-4 mb-10" action="{{ route('employee.index') }}" method="GET">
        <h2 class="col-span-12 font-bold text-xl">
            {{ __('Search Users') }}
        </h2>
        <div class="col-span-6">
            <x-label for="user_email" :value="__('Email')" />

            <x-input id="user_email" :value="$oldInput['user_email'] ?? ''" class="block mt-1 w-full" type="text" name="user_email"
                autofocus />
        </div>


        <div class="col-span-6">
            <x-label for="branch_id" :value="__('Branch')" />

            <x-select id="branch_id" :selected="$oldInput['branch_id'] ?? ''" name="branch_id" :options="$branches" />
        </div>

        <div class="col-span-12 flex w-full justify-end">
            <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
        </div>
    </form>
</div>
