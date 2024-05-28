<x-modal :title="__('Show Pet')" :btnText="__('Show Pet')" btnClass="btn-sm btn-success">
    <form method="POST" class="w-full flex flex-col md:grid grid-cols-12 ga-2 md:gap-4"
        action="{{ route('pet.update', ['id' => $pet->pet_id, 'user' => $pet->user_id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <x-input id="redirect_pet_index" class="block mt-1 w-full" type="hidden" name="redirect_pet_index"
            :value="$redirect_pet_index ?? 0" required autofocus />

        <div class="col-span-12">
            <x-show-image dataID="{{ $pet->pet_id }}" :path="$pet->image->image_path ?? false" id="pet_avatar" :label="__('pet.avatar')" />
        </div>

        <div class="col-span-6">
            <x-label required for="pet_name" :value="__('Pet Name')" />

            <x-input id="pet_name" class="block mt-1 w-full" type="text" name="pet_name" :value="$pet->pet_name" required
                autofocus />
        </div>
        <div class="col-span-6">
            <x-label required for="pet_type" :value="__('Pet Type')" />
            <x-select required id="pet_type" :selected="$pet->pet_type" name="pet_type" :options="$petTypesSelected" />

        </div>
        <div class="col-span-6">
            <x-label for="pet_description" :value="__('Pet Description')" />

            <x-textarea id="pet_description" class="block mt-1 w-full" name="pet_description" :value="$pet->pet_description" />
        </div>
        <!-- Birthdate -->
        <div class=" col-span-6">
            <x-label for="birthdate" :value="__('Pet Birthdate')" />
            <x-input id="birthdate" class="block mt-1 w-full" type="date" name="pet_birthdate" :value="formatDate($pet->pet_birthdate, 'Y-m-d')" />
        </div>

        <div class="col-span-6">
            <x-label required for="pet_weight" :value="__('Pet Weight')" />
            <x-input id="pet_weight" class="block mt-1 w-full" type="number" name="pet_weight" :value="$pet->pet_weight"
                required />
        </div>


        <div class="col-span-6">
            <x-label for="pet_breed" :value="__('Pet Breed')" />

            <x-select id="pet_breed" :options="$breeds" class="block mt-1 w-full" name="breed_id" :selected="$pet->breed_id" />
        </div>


        <div class="col-span-6">
            <x-label class="mb-4 " for="male" :value="__('Pet Gender')" />
            <div class=" flex items-center gap-6 w-full mt-4">
                <div>
                    <x-label for="male" class="inline-flex" :value="__('PetMale')" />

                    <x-input id="male" class="" type="radio" :checked="$pet->pet_gender == 0" name="pet_gender"
                        value="0" />
                </div>

                <div>
                    <x-label for="female" class="inline-flex" :value="__('PetFemale')" />

                    <x-input id="female" :checked="$pet->pet_gender == 1" class="" type="radio" name="pet_gender"
                        value="1" />
                </div>



            </div>
        </div>
        <div class="col-span-6">
            <x-label class="mb-4" required for="is_active" :value="__('Is Active')" />
            <div class="flex w-5 h-5">
                <x-input id="is_active" :checked="$pet->is_active" class="block mt-1 w-full" type="checkbox" name="is_active"
                    :value="old('is_active')" />
            </div>

        </div>


        </div>
        <x-modal-footer />

    </form>
</x-modal>
