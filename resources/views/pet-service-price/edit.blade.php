<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            <x-breadcrumb :items="$breadcrumbItems" />
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-alert-session />
                    <form method="POST" class="w-full flex flex-col md:grid grid-cols-12 ga-2 md:gap-4"
                        action="{{ route('pet-service-price.update', ['pet_service' => $petServiceID, 'pet_service_price' => $petServicePrice->pet_service_price_id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="col-span-6">
                            <x-label required for="pet_service_price" :value="__('pet-service-price.price')" />

                            <x-input id="pet_service_price" class="block mt-1 w-full" type="number"
                                name="pet_service_price" :value="$petServicePrice->pet_service_price" required autofocus />
                        </div>

                        <div class="col-span-6">
                            <x-label required for="pet_service_weight" :value="__('pet-service-price.weight')" />

                            <x-select id="pet_service_weight" class="block mt-1 w-full" name="pet_service_weight"
                                :selected="$petServicePrice->pet_service_weight" :options="formatSelectWeightPrice()" required autofocus />
                        </div>


                        <div class="col-span-12 flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                </div>

                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
