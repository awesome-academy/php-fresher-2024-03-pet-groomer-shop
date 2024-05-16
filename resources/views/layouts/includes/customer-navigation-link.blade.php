<!-- Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
        {{ __('Home') }}
    </x-nav-link>
</div>

@auth
    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <x-nav-link :href="route('care-order.index')" :active="request()->routeIs('care-order.index')">
            {{ __('care-order.care-order') }}
        </x-nav-link>
    </div>

@endauth
