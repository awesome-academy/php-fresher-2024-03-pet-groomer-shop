<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('branch.branch') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6  border-b ">
                    <a href="{{ route('branch.create') }}">
                        <button class="btn btn-sm btn-primary mb-5">{{ __('branch.create') }}</button></a>
                    <x-display-infor />
                    <table class="min-w-full  text-left text-sm font-light text-surface m-4">
                        <thead class="border-b  font-medium ">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">{{ __('branch.name') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('branch.address') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('branch.phone') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($branches as $branch)
                                <tr class="border-b">
                                    <td class="whitespace-nowrap px-6 py-4">{{ $branch->branch_id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $branch->branch_name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $branch->branch_address }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $branch->branch_phone }}</td>

                                    <td class="whitespace-nowrap px-6 py-4 flex gap-2">

                                        <a href="{{ route('branch.edit', ['branch' => $branch->branch_id]) }}">
                                            <button class="btn btn-primary">
                                                {{ trans('Update') }}
                                            </button>
                                        </a>

                                        <button type="submit" data-id="{{ $branch->branch_id }}"
                                            class="btn btn-danger delete-branch-btn">
                                            {{ __('Delete') }}
                                        </button>


                                    </td>

                                </tr>
                            @empty
                                <h4 class="text-center italic">{{ __('branch.not_found') }}</h4>
                            @endforelse

                        </tbody>

                    </table>

                    <div class="mt-3">
                        {{ $branches->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
