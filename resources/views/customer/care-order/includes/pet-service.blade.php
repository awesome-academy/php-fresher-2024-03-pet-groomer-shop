<h2 class="my-4 text-2xl font-normal">
    {{ __('pet-service.pet_service') . ' 😸:' }}
</h2>
<div class=" flex flex-col flex-wrap md:grid grid-cols-12 gap-4">
    @forelse ($petServices as $petService)
        <div class="col-span-3">
            <x-label :for="$petService->pet_service_name" class="font-bold" :value="$petService->pet_service_name" />

            <x-input :id="$petService->pet_service_name" class="block mt-1 w-5" type="checkbox" name="pet_service_id[]"
                value="{{ $petService->pet_service_id }}" autofocus />
        </div>
    @empty
        <h3>
            {{ __('pet-service.not_found') }}
        </h3>
    @endforelse

</div>
