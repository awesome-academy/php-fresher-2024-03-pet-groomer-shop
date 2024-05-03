@php
    $activeMenu = \App\Enums\StatusEnum::getTranslated();
    $ADMIN = \App\Enums\RoleEnum::ADMIN;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('pet-service.pet_service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6  border-b ">
                    <a href="{{ route('pet-service.create') }}">
                        <button class="btn btn-sm btn-primary mb-5">{{ __('pet-service.create') }}</button></a>
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <x-alert-session />
                    <table class="min-w-full text-left text-sm font-light text-surface ">
                        <thead class="border-b  font-medium ">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">{{ __('pet-service.name') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('pet-service.description') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Created At') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Updated At') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($petServices as $petService)
                                <tr class="border-b  ">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">
                                        {{ $petService->pet_service_id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $petService->pet_service_name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $petService->pet_service_description }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $petService->created_at }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $petService->updated_at }}
                                    </td>


                                    <td class="whitespace-nowrap flex gap-3 px-6 py-4">

                                        <a
                                            href="{{ route('pet-service.edit', ['pet_service' => $petService->pet_service_id]) }}">
                                            <button class="btn btn-success">{{ __('Update') }}</button></a>

                                        <button data-id={{ $petService->pet_service_id }}
                                            class="btn btn-danger delete-pet-service-btn">{{ __('Delete') }}</button>

                                    </td>

                                </tr>
                            @empty
                                @if (count($petServices) == 0)
                                    <h4 class="text-center italic">{{ __('pet-service.not_found') }}</h4>
                                @endif
                            @endforelse

                        </tbody>
                    </table>

                    <div class="my-4">
                        {{ $petServices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
