<!-- Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>
</div>
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.index')">
        {{ __('User') }}
    </x-nav-link>
</div>
@admin
    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <x-nav-link :href="route('role.index')" :active="request()->routeIs('role.index')">
            {{ __('Role') }}
        </x-nav-link>
    </div>
    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <x-nav-link :href="route('permission.index')" :active="request()->routeIs('permission.index')">
            {{ __('Permission') }}
        </x-nav-link>
    </div>
@endadmin
