<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('Pet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('customer-pet.create', ['customer' => Auth::user()->user_id]) }}">
                        <button class="btn btn-sm btn-primary mb-5">{{ __('pet.create') }}</button></a>
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <x-alert-session />
                    @include('customer.pet.includes.search')
                    <table class="min-w-full  text-left text-sm font-light text-surface m-4">
                        <thead class="border-b  font-medium ">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">{{ __('pet.avatar') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Pet Name') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Pet Type') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Pet Birthdate') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Is Active') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Action') }}</th>


                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($pets as $pet)
                                <tr class="border-b">
                                    <td class="whitespace-nowrap px-6 py-4">{{ $pet->pet_id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">

                                        @if ($pet->image->image_path ?? false)
                                            <img class="w-16 h-16 my-4 rounded-md shadow-sm"
                                                src="{{ asset('storage/' . $pet->image->image_path) }}"
                                                alt="pet_avatar" />
                                        @else
                                            <img
                                                class="w-16 h-16 my-4 rounded-md shadow-sm"
                                                src="{{ asset('img/default-image.png') }}" alt="default_img">
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $pet->pet_name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $pet->pet_type_name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ formatDate($pet->pet_birthdate) }}</td>
                                        {{ $pet->is_active_name }}</td>


                                    <td class="whitespace-nowrap px-6 py-4 mt-6 flex gap-2">

                                        @include('customer.pet.includes.show', [
                                            'pet' => $pet,
                                            'redirect_pet_index' => 1,
                                        ])

                                        <button type="submit" data-user-id="{{ $pet->user->user_id }}"
                                            data-pet-id="{{ $pet->pet_id }}"
                                            class="btn btn-danger delete-customer-pet-btn">
                                            {{ __('Delete') }}
                                        </button>


                                    </td>

                                </tr>
                            @empty
                                <h4 class="text-center italic">{{ __('No pet found') }}</h4>
                            @endforelse

                        </tbody>

                    </table>

                    <div class="mt-3">
                        {{ $pets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
