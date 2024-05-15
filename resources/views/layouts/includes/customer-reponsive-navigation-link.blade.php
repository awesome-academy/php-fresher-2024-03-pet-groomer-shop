  <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
      {{ __('Home') }}
  </x-responsive-nav-link>
