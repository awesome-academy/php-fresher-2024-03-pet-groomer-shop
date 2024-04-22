<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6  border-b ">
                    <a href="{{ route('user.create') }}">
                        <button class="btn btn-sm btn-primary mb-5">{{ __('Create User') }}</button></a>
                    <table class="min-w-full text-left text-sm font-light text-surface ">
                        <thead class="border-b  font-medium ">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">{{ __('Full Name') }}</th>
                                <th scope="col" class="px-6 py-4">Email</th>
                                <th scope="col" class="px-6 py-4">Username</th>
                                <th scope="col" class="px-6 py-4">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b  ">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $user->user_id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $user->full_name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $user->user_email }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $user->username }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <a href="{{ route('user.show', ['user' => $user->user_id]) }}">

                                            <button class="btn btn-success">
                                                {{ __('Show') }}
                                            </button>

                                        </a>
                                        <form class="inline-flex"
                                            action="{{ route('user.destroy', ['user' => $user->user_id]) }}"
                                            method="POST">
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                {{ __('Delete') }}
                                            </button>

                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
