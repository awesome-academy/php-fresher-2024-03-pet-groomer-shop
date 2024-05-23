<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('Pet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6  border-b ">
                    <a href="{{ route('pet.create') }}">
                        <button class="btn btn-sm btn-primary mb-5">{{ __('pet.create') }}</button></a>
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <x-alert-session />
                    @include('pet.includes.search')
                    <table class="min-w-full  text-left text-sm font-light text-surface m-4">
                        <thead class="border-b  font-medium ">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">{{ __('Pet Name') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Pet Type') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Pet Breed') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Pet Birthdate') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Is Active') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Pet Owner') }}</th>

                                <th scope="col" class="px-6 py-4">{{ __('Action') }}</th>


                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($pets as $pet)
                                <tr class="border-b  ">
                                    <td class="whitespace-nowrap px-6 py-4">{{ $pet->pet_id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $pet->pet_name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $petTypes[$pet->pet_type] }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $pet->breed->breed_name ?? '' }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ formatDate($pet->pet_birthdate) }}</td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4
                                        {{ $pet->is_active ? ' text-green-500' : ' text-red-500' }}">
                                        {{ $pet->is_active_name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <a class="text-indigo-600"
                                            href="{{ route('user.show', $pet->user->user_id) }}">
                                            {{ $pet->user->user_email }}
                                        </a>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 flex gap-2">

                                        @include('user.includes.show-pet', [
                                            'pet' => $pet,
                                            'redirect_pet_index' => 1,
                                        ])

                                        <button type="submit" onclick="window.pet.delete({{ $pet->pet_id }})"
                                            class="btn btn-danger">
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
</x-app-layout>
