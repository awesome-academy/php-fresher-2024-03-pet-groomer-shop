<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('Permission') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6  border-b ">
                    <a href="{{ route('permission.create') }}">
                        <button class="btn btn-sm btn-primary mb-5">{{ __('permission.create') }}</button></a>
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <x-alert-session />
                    <table class="min-w-full text-left text-sm font-light text-surface ">
                        <thead class="border-b  font-medium ">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">{{ __('permission.name') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Created At') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Updated At') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($permissions as $permission)
                                <tr class="border-b  ">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $permission->permission_id }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $permission->permission_name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $permission->created_at }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $permission->updated_at }}</td>

                                    <td class="whitespace-nowrap flex gap-3 px-6 py-4">



                                        @include('permission.edit', ['permission' => $permission])

                                        <a
                                            href="{{ route('permission.attach-role-page', ['permission' => $permission->permission_id]) }}">
                                            <button class="btn btn-success">{{ __('permission.attach_role') }}</button></a>

                                        <form method="POST"
                                            action="{{ route('permission.destroy', ['permission' => $permission->permission_id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>




                                    </td>

                                </tr>
                            @empty
                                @if (count($permissions) == 0)
                                    <h4 class="text-center italic">{{ __('permission.not_found') }}</h4>
                                @endif
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
