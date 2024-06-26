  <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
      {{ __('Dashboard') }}
  </x-responsive-nav-link>
  <x-responsive-nav-link :href="route('user.index')" :active="request()->routeIs('user.index')">
      {{ __('User') }}
  </x-responsive-nav-link>
  <x-responsive-nav-link :href="route('pet.index')" :active="request()->routeIs('pet.index')">
      {{ __('Pet') }}
  </x-responsive-nav-link>
  <x-responsive-nav-link :href="route('care-order-manage.index')" :active="request()->routeIs('care-order-manage.index')">
      {{ __('care-order.care-order') }}
  </x-responsive-nav-link>
  <x-responsive-nav-link :href="route('employee.index')" :active="request()->routeIs('employee.index')">
      {{ __('employee.employee') }}
  </x-responsive-nav-link>
  <x-responsive-nav-link :href="route('pet-service.index')" :active="request()->routeIs('pet-service.index')">
      {{ __('pet-service.pet_service') }}
  </x-responsive-nav-link>
  @manager
      <x-responsive-nav-link :href="route('coupon.index')" :active="request()->routeIs('coupon.index')">
          {{ __('coupon.coupon') }}
      </x-responsive-nav-link>
      <x-responsive-nav-link :href="route('breed.index')" :active="request()->routeIs('breed.index')">
          {{ __('breed.breed') }}
      </x-responsive-nav-link>

      <x-responsive-nav-link :href="route('branch.index')" :active="request()->routeIs('branch.index')">
          {{ __('branch.branch') }}
      </x-responsive-nav-link>
  @endmanager
