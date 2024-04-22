@php
    $activeMenu = \App\Enums\StatusEnum::getTranslated();
    $petTypes = \App\Enums\PetTypeEnum::getTranslated();
    $petTypesSelected = array_flip($petTypes);
@endphp

@include('user.includes.create-pet')

<table class="min-w-full text-left text-sm font-light text-surface m-4">
    <thead class="border-b  font-medium ">
        <tr>
            <th scope="col" class="px-6 py-4">#</th>
            <th scope="col" class="px-6 py-4">{{ __('Pet Name') }}</th>
            <th scope="col" class="px-6 py-4">{{ __('Pet Type') }}</th>
            <th scope="col" class="px-6 py-4">{{ __('Pet Breed') }}</th>
            <th scope="col" class="px-6 py-4">{{ __('Pet Birthdate') }}</th>
            <th scope="col" class="px-6 py-4">{{ __('Is Active') }}</th>
            <th scope="col" class="px-6 py-4">{{ __('Action') }}</th>


        </tr>
    </thead>
    <tbody>

        @forelse ($user->pets as $pet)
            <tr class="border-b  ">
                <td class="whitespace-nowrap px-6 py-4">{{ $pet->pet_id }}</td>
                <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $pet->pet_name }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $petTypes[$pet->pet_type] }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $pet->breed_id }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ formatDate($pet->pet_birthdate) }}</td>
                <td
                    class="whitespace-nowrap px-6 py-4
                                        {{ $pet->is_active ? ' text-green-500' : ' text-red-500' }}">
                    {{ $activeMenu[$pet->is_active] }}</td>

                <td class="whitespace-nowrap px-6 py-4 flex gap-2">

                    @include('user.includes.show-pet', ['pet' => $pet])

                    <form method="POST"
                        action="{{ route('pet.delete', ['id' => $pet->pet_id, 'user' => $user->user_id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            {{ __('Delete') }}
                        </button>

                    </form>


                </td>

            </tr>
        @empty
            <h4 class="text-center italic">{{ __('No pet found') }}</h4>
        @endforelse

    </tbody>

</table>
