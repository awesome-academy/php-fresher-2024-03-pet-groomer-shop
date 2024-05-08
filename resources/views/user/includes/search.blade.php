<div>
    <form class=" flex flex-wrap md:grid grid-cols-12 gap-4 my-4 mb-10" action="{{ route('user.index') }}" method="GET">
        <h2 class="col-span-12 font-bold text-xl">
            {{ __('Search Users') }}
        </h2>
        <div class="col-span-6">
            <x-label for="user_email" :value="__('Email')" />

            <x-input id="user_email" :value="$oldInput['user_email'] ?? ''" class="block mt-1 w-full" type="text" name="user_email"
                autofocus />
        </div>

        <div class="col-span-6">
            <x-label for="username" :value="__('Username')" />

            <x-input id="username" :value="$oldInput['username'] ?? ''" class="block mt-1 w-full" type="text" name="username"
                autofocus />
        </div>

        <div class="col-span-6">
            <x-label for="role_id" :value="__('Role')" />

            <x-select id="role_id" :selected="$oldInput['role_id'] ?? ''" name="role_id" :options="$roles" />
        </div>

        <div class="col-span-12 flex w-full justify-end">
            <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
        </div>
    </form>
</div>
