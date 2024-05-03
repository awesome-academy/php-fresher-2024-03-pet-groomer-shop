<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6  border-b ">
                    <a href="{{ route('role.create') }}">
                        <button class="btn btn-sm btn-primary mb-5">{{ __('role.create') }}</button></a>
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <x-alert-session />
                    <table class="min-w-full text-left text-sm font-light text-surface ">
                        <thead class="border-b  font-medium ">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">{{ __('role.name') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Created At') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Updated At') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($roles as $role)
                                <tr class="border-b  ">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $role->role_id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $role->role_name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $role->created_at }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $role->updated_at }}</td>

                                    <td class="whitespace-nowrap flex gap-3 px-6 py-4">


                                        @if ($role->role_id != $ADMIN)
                                            @include('role.edit', ['role' => $role])

                                            <form method="POST"
                                                action="{{ route('role.destroy', ['role' => $role->role_id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        @endif





                                    </td>

                                </tr>
                            @empty
                                @if (count($roles) == 0)
                                    <h4 class="text-center italic">{{ __('role.not_found') }}</h4>
                                @endif
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
