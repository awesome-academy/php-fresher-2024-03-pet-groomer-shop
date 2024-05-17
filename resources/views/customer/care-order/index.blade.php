<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="my-3">
                        <x-alert-session />
                    </div>
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="POST" class="w-full grid grid-cols-12 gap-4"
                        action="{{ route('customer-profile.update', ['customer_profile' => $user->user_id]) }}">
                        @method('PUT')
                        @csrf


                    </form>


                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
