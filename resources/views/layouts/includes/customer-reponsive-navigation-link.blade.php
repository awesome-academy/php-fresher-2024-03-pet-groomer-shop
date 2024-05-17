  <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
      {{ __('Home') }}
  </x-responsive-nav-link>

  @auth
      <x-responsive-nav-link :href="route('care-order.index')" :active="request()->routeIs('care-order.index')">
          {{ __('care-order.care-order') }}
      </x-responsive-nav-link>
  @endauth
