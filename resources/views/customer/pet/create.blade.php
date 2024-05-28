<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            <x-breadcrumb :items="$breadcrumbItems" />
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-display-infor />
                    <form enctype="multipart/form-data" method="POST"
                        class="w-full flex flex-col md:grid grid-cols-12 ga-2 md:gap-4"
                        action="{{ route('customer-pet.store', ['customer' => Auth::user()->user_id]) }}">
                        @csrf

                        <div class="col-span-12">
                            <x-show-image id="pet_avatar" label="Pet Avatar" />
                        </div>

                        <div class="col-span-6">
                            <x-label required for="pet_name" :value="__('Pet Name')" />

                            <x-input id="pet_name" class="block mt-1 w-full" type="text" name="pet_name"
                                :value="old('pet_name')" required autofocus />
                        </div>
                        <div class="col-span-6">
                            <x-label required for="pet_type" :value="__('Pet Type')" />
                            <x-select required id="pet_type" name="pet_type" :options="$petTypesSelected" />

                        </div>
                        <div class="col-span-6">
                            <x-label for="pet_description" :value="__('Pet Description')" />

                            <x-textarea id="pet_description" class="block mt-1 w-full" name="pet_description"
                                :value="old('pet_description')" />
                        </div>
                        <!-- Birthdate -->
                        <div class=" col-span-6">
                            <x-label for="birthdate" :value="__('Pet Birthdate')" />

                            <x-input id="birthdate" class="block mt-1 w-full" type="date" name="pet_birthdate"
                                :value="old('pet_birthdate')" />
                        </div>

                        <div class="col-span-6">
                            <x-label required for="pet_weight" :value="__('Pet Weight')" />

                            <x-input id="pet_weight" class="block mt-1 w-full" type="number" name="pet_weight"
                                :value="old('pet_weight')" required />
                        </div>


                        <div class="col-span-6">
                            <x-label for="pet_breed" :value="__('Pet Breed')" />

                            <x-select id="pet_breed" :options="$breeds" class="block mt-1 w-full" name="breed_id"
                                :value="old('pet_breed')" />
                        </div>


                        <div class="col-span-6">
                            <x-label class="mb-4 " for="male" :value="__('Pet Gender')" />
                            <div class=" flex items-center gap-6 w-full mt-4">
                                <div>
                                    <x-label for="male" class="inline-flex" :value="__('PetMale')" />

                                    <x-input id="male" class="" type="radio" checked name="pet_gender"
                                        value="0" />
                                </div>

                                <div>
                                    <x-label for="female" class="inline-flex" :value="__('PetFemale')" />

                                    <x-input id="female" class="" type="radio" name="pet_gender"
                                        value="1" />
                                </div>



                            </div>
                        </div>
                        <div class="col-span-6">
                            <x-label class="mb-4" required for="is_active" :value="__('Is Active')" />
                            <div class="flex w-5 h-5">
                                <x-input id="is_active" checked="checked" class="block mt-1 w-full" type="checkbox"
                                    name="is_active" :value="old('is_active')" />
                            </div>

                        </div>

                        <div class="col-span-12 flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Create') }}
                            </x-button>
                        </div>
                </div>

                </form>
            </div>
        </div>
    </div>
    </div>
    </x-app-layout>
