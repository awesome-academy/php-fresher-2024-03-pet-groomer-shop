<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('auth.change_password') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="my-3">
                        <x-display-infor />
                    </div>
                    <form method="POST" class="w-full md:grid grid-cols-12 flex flex-wrap gap-4" action="{{ route('change.password') }}">

                        @csrf

                        <div class="col-span-6">
                            <x-label for="old_password" required :value="__('auth.current_password')" />

                            <x-input id="old_password" class="block mt-1 w-full" type="password" name="old_password"
                                required autofocus />
                        </div>

                        <div class="col-span-6">
                            <div class="flex flex-col flex-wrap gap-3">
                                <div>
                                    <x-label for="password" required :value="__('auth.new_password')" />

                                    <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                                        required autofocus />
                                </div>
                                <div>
                                    <x-label for="password_confirmation" required :value="__('auth.confirm_password')" />

                                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                        name="password_confirmation" required autofocus />

                                </div>

                            </div>

                        </div>






                        <div class="col-span-12 flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
