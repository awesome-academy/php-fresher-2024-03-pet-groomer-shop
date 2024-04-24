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
        @foreach ($user->pets as $pet)
            <tr class="border-b  ">
                <td class="whitespace-nowrap px-6 py-4">{{ $pet->pet_id }}</td>
                <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $pet->pet_name }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $pet->pet_type }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $pet->breed_id }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $pet->pet_birthdate }}</td>
                <td class="whitespace-nowrap px-6 py-4">{{ $pet->is_active }}</td>


                <td class="whitespace-nowrap px-6 py-4">


                    <button class="btn btn-success">
                        {{ __('Show') }}
                    </button>



                    <button type="submit" class="btn btn-danger">
                        {{ __('Delete') }}
                    </button>


                </td>

            </tr>
        @endforeach

    </tbody>
</table>
