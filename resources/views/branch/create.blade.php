<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-breadcrumb :items="$breadcrumbItems" />
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-display-infor />

                    <form method="POST"
                        class="w-full flex flex-col
                    md:grid grid-cols-12 gap-2 md:gap-4"
                        action="{{ route('branch.store') }}">
                        @csrf
                        <div class="col-span-6">
                            <x-label for="branch_name" required :value="__('branch.name')" />

                            <x-input id="branch_name" class="block mt-1 w-full" type="text" name="branch_name"
                                :value="old('branch_name')" required autofocus />
                        </div>
                        <div class="col-span-6">
                            <x-label for="branch_address" required :value="__('branch.address')" />

                            <x-input id="branch_address" class="block mt-1 w-full" type="text" name="branch_address"
                                :value="old('branch_address')" required autofocus />
                        </div>
                        <div class="col-span-6">
                            <x-label for="branch_phone" required :value="__('branch.phone')" />

                            <x-input id="branch_phone" class="block mt-1 w-full" type="text" name="branch_phone"
                                :value="old('branch_phone')" required autofocus />
                        </div>



                        <div class="col-span-12 flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Create') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
