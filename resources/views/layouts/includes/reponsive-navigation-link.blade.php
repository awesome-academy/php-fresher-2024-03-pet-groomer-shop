  <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
      {{ __('Dashboard') }}
  </x-responsive-nav-link>
  <x-responsive-nav-link :href="route('user.index')" :active="request()->routeIs('user.index')">
      {{ __('User') }}
  </x-responsive-nav-link>
  <x-responsive-nav-link :href="route('pet.index')" :active="request()->routeIs('pet.index')">
      {{ __('Pet') }}
  </x-responsive-nav-link>
  <x-responsive-nav-link :href="route('employee.index')" :active="request()->routeIs('employee.index')">
      {{ __('employee.employee') }}
  </x-responsive-nav-link>
  @admin
      <x-responsive-nav-link :href="route('role.index')" :active="request()->routeIs('role.index')">
          {{ __('Role') }}
      </x-responsive-nav-link>
      <x-responsive-nav-link :href="route('permission.index')" :active="request()->routeIs('permission.index')">
          {{ __('Permission') }}
      </x-responsive-nav-link>
  @endadmin
