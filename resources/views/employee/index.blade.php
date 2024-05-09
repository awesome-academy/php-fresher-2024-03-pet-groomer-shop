<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('employee.employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6  border-b ">
                    <a href="{{ route('user.create') }}">
                        <button class="btn btn-sm btn-primary mb-5">{{ __('Create User') }}</button></a>

                    <x-alert-session />

                    @include('employee.includes.search')
                    <table class="min-w-full text-left text-sm font-light text-surface ">
                        <thead class="border-b  font-medium ">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">{{ __('Full Name') }}</th>
                                <th scope="col" class="px-6 py-4">Email</th>
                                <th scope="col" class="px-6 py-4">{{ __('Branch') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($employees as $employee)
                                <tr class="border-b  ">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $employee->user_id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $employee->full_name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $employee->user_email }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $employee->branch->branch_name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <a href="{{ route('user.show', ['user' => $employee->user_id]) }}">

                                            <button class="btn btn-success">
                                                {{ __('Show') }}
                                            </button>

                                        </a>
                                        <a
                                            href="{{ route('employee.assign-task-page', ['employee' => $employee->user_id, 'branch' => $employee->branch->branch_id]) }}">

                                            <button class="btn btn-primary">
                                                {{ __('employee.assign_task') }}
                                            </button>

                                        </a>
                                        @if ($employee->user_id != Auth::user()->user_id)
                                            <button onclick="window.user.delete({{ $employee->user_id }})"
                                                type="button" class="btn btn-danger">
                                                {{ __('Delete') }}
                                            </button>
                                        @endif

                                    </td>

                                </tr>
                            @empty
                                @if (count($employees) == 0)
                                    <h4 class="text-center italic">{{ __('No user found') }}</h4>
                                @endif
                            @endforelse

                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
