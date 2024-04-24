 @php
     $petTypes = array_flip(Config::get('constant.pet_type'));
 @endphp

 <x-modal :title="__('Create Pet')" :btnText="__('Create Pet')" btnClass="btn-sm">
     <form method="POST" class="w-full flex flex-col md:grid grid-cols-12 ga-2 md:gap-4"
         action="{{ route('pet.store') }}">
         @csrf

         <div class="col-span-6">
             <x-label required for="pet_name" :value="__('Pet Name')" />

             <x-input id="pet_name" class="block mt-1 w-full" type="text" name="pet_name" :value="old('pet_name')" required
                 autofocus />
         </div>
         <div class="col-span-6">
             <x-label required for="pet_type" :value="__('Pet Type')" />
             <x-select required id="pet_type" name="pet_type" :options="$petTypes" />

         </div>
         <div class="col-span-6">
             <x-label for="pet_description" :value="__('Pet Description')" />

             <x-textarea id="pet_description" class="block mt-1 w-full" name="pet_description" :value="old('pet_description')" />
         </div>
         <!-- Birthdate -->
         <div class=" col-span-6">
             <x-label for="birthdate" :value="__('Pet Birthdate')" />

             <x-input id="birthdate" class="block mt-1 w-full" type="date" name="pet_birthdate" :value="old('pet_birthdate')"
                 required />
         </div>

         <div class="col-span-6">
             <x-label required for="pet_weight" :value="__('Pet Weight')" />

             <x-input id="pet_weight" class="block mt-1 w-full" type="number" name="pet_weight" :value="old('pet_weight')"
                 required />
         </div>


         <div class="col-span-6">
             <x-label for="pet_breed" :value="__('Pet Breed')" />

             <x-select id="pet_breed" :options="$breeds" class="block mt-1 w-full" name="pet_breed" :value="old('pet_breed')"
                 required />
         </div>


         <div class="col-span-6">
             <x-label class="mb-4 " for="male" :value="__('Pet Gender')" />
             <div class=" flex items-center gap-6 w-full mt-4">
                 <div>
                     <x-label for="male" class="inline-flex" :value="__('Male')" />

                     <x-input id="male" class="" type="radio" checked name="user_gender" value="0" />
                 </div>

                 <div>
                     <x-label for="female" class="inline-flex" :value="__('Female')" />

                     <x-input id="female" class="" type="radio" name="user_gender" value="1" />
                 </div>



             </div>
         </div>
         <div class="col-span-6">
             <x-label class="mb-4" required for="is_active" :value="__('Is Active')" />
             <div class="flex w-5 h-5">
                 <x-input id="is_active" class="block mt-1 w-full" type="checkbox" name="is_active" :value="old('is_active')"
                     required />
             </div>

         </div>


         </div>
         <x-modal-footer />

     </form>
 </x-modal>
