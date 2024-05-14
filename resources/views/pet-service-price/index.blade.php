<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('pet-service-price.pet_service_price') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6  border-b ">
                    <a href="{{ route('pet-service-price.create', ['pet_service' => $petServiceID]) }}">
                        <button class="btn btn-sm btn-primary mb-5">{{ __('pet-service-price.create') }}</button></a>
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <x-alert-session />
                    <h3 class="text-left font-bold text-lg my-3">
                        {{ __('pet-service-price.belong') . ' : ' . $petService->pet_service_name }}
                    </h3>
                    <table class="min-w-full text-left text-sm font-light text-surface ">
                        <thead class="border-b  font-medium ">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">{{ __('pet-service-price.price') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('pet-service-price.weight') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Created At') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Updated At') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($petServicePrices as $key =>$petServicePrice)
                                <tr class="border-b  ">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">
                                        {{ $key + 1 }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $petServicePrice->price_format }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ '< ' . $petServicePrice->weight_format }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $petServicePrice->created_at }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $petServicePrice->updated_at }}
                                    </td>


                                    <td class="whitespace-nowrap flex gap-3 px-6 py-4">

                                        <a
                                            href="{{ route('pet-service-price.edit', ['pet_service_price' => $petServicePrice->pet_service_price_id, 'pet_service' => $petServiceID]) }}">
                                            <button class="btn btn-success">{{ __('Update') }}</button></a>


                                        <button data-pet-service-id={{ $petServiceID }}
                                            data-id={{ $petServicePrice->pet_service_price_id }}
                                            class="btn btn-danger delete-pet-service-price-btn">{{ __('Delete') }}</button>

                                    </td>

                                </tr>
                            @empty
                                @if (count($petServicePrices) == 0)
                                    <h4 class="text-center italic">{{ __('pet-service-price.not_found') }}</h4>
                                @endif
                            @endforelse

                        </tbody>
                    </table>

                    <div class="my-4">
                        {{ $petServicePrices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
