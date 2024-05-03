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

                    <x-alert-session />

                    @include('user.includes.search')
                    <table class="min-w-full text-left text-sm font-light text-surface ">
                        <thead class="border-b  font-medium ">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">{{ __('Full Name') }}</th>
                                <th scope="col" class="px-6 py-4">Email</th>
                                <th scope="col" class="px-6 py-4">Username</th>
                                <th scope="col" class="px-6 py-4">{{ __('Is Active') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Role') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($users as $user)
                                <tr class="border-b  ">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $user->user_id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $user->full_name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $user->user_email }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $user->username }}</td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4
                                        {{ $user->is_active ? ' text-green-500' : ' text-red-500' }}">
                                        {{ $user->is_active_name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $roleEnum[$user->role_id] }}</td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        <a href="{{ route('user.show', ['user' => $user->user_id]) }}">

                                            <button class="btn btn-success">
                                                {{ __('Show') }}
                                            </button>

                                        </a>
                                        @if ($user->user_id != Auth::user()->user_id)
                                            <button data-id="{{ $user->user_id }}" type="button"
                                                class="btn btn-danger delete-user-btn">
                                                {{ __('Delete') }}
                                            </button>
                                        @endif

                                    </td>

                                </tr>
                            @empty
                                @if (count($users) == 0)
                                    <h4 class="text-center italic">{{ __('No user found') }}</h4>
                                @endif
                            @endforelse

                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
