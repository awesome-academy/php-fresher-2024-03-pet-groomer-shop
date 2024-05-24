<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('breed.breed') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6  border-b ">
                    <a href="{{ route('breed.create') }}">
                        <button class="btn btn-sm btn-primary mb-5">{{ __('breed.create') }}</button></a>
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <x-alert-session />
                    <table class="min-w-full text-left text-sm font-light text-surface ">
                        <thead class="border-b  font-medium ">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">{{ __('breed.name') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('breed.description') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('breed.type') }}</th>

                                <th scope="col" class="px-6 py-4">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($breeds as $breed)
                                <tr class="border-b  ">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $breed->breed_id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $breed->breed_name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $breed->breed_description }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ $breed->breed_type_name }}
                                    </td>
                                    <td class="whitespace-nowrap flex gap-3 px-6 py-4">

                                        <a href="{{ route('breed.edit', ['breed' => $breed->breed_id]) }}">
                                            <button type="submit" class="btn btn-success">
                                                {{ __('Update') }}
                                            </button>
                                        </a>

                                        <button type="button" data-id={{ $breed->breed_id }}
                                            class="btn btn-danger delete-breed-btn">
                                            {{ __('Delete') }}
                                        </button>

                                    </td>

                                </tr>
                            @empty
                                @if (count($breeds) == 0)
                                    <h4 class="text-center italic">{{ __('breed.not_found') }}</h4>
                                @endif
                            @endforelse

                        </tbody>
                    </table>


                    <div class="mt-4">
                        {{ $breeds->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
