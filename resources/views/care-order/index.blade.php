<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('care-order.care-order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6  border-b ">
                    <a href="{{ route('employee.index') }}">
                        <button
                            class="btn btn-sm btn-primary mb-5">{{ __('Go to page :page', ['page' => __('employee.employee')]) }}</button></a>
                    <x-display-infor />

                    @include('care-order.include.search')
                    <table class="min-w-full text-left text-sm font-light text-surface ">
                        <thead class="border-b  font-medium ">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">{{ __('pet.name') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('care-order.received_date') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('order.returned_date') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('care-order.total_price') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('branch.branch') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('employee.employee') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('care-order.status') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($careOrders as $careOrder)
                                <tr class="border-b  ">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $careOrder->order_id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $careOrder->pet->pet_name }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ formatDate($careOrder->order_received_date, 'd-m-Y H:i') }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ formatDate($careOrder->returned_date, 'd-m-Y H:i') }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $careOrder->total_price_format }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $careOrder->branch->branch_id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <a class="text-blue-500"
                                            href="{{ route('user.show', ['user' => $careOrder->assignTask->first()->user_id ?? -1]) }}">
                                            {{ $careOrder->assignTask->first()->fullname ?? 'N/A' }}
                                        </a>
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 {{ orderStatusColor($careOrder->order_status) }}">
                                        {{ $careOrder->order_status_name }}</td>
                                    <td class="whitespace-nowrap flex gap-3 px-6 py-4">
                                        <div class="flex flex-wrap items-center gap-4">
                                            <a
                                                href="{{ route('care-order-manage.show', ['care_order_manage' => $careOrder->order_id]) }}">
                                                <button type="submit" class="btn btn-success">
                                                    {{ __('Detail') }}
                                                </button>
                                            </a>

                                            @include('care-order.include.drop-down-order-status')

                                            <a
                                                href="{{ route('employee.index', ['branch_id' => $careOrder->branch_id]) }}">
                                                <button
                                                    class="btn btn-warning">{{ trans('employee.assign_task') }}</button>
                                            </a>

                                        </div>


                                    </td>

                                </tr>
                            @empty
                                @if (count($careOrders) == 0)
                                    <h4 class="text-center italic">{{ __('care-order.not_found') }}</h4>
                                @endif
                            @endforelse

                        </tbody>

                    </table>


                    <div class="mt-4">
                        {{ $careOrders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
