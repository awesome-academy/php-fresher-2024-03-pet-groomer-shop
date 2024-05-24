<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-breadcrumb :items="$breadcrumbItems" />
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-display-infor />
                    <div class="font-bold text-lg mb-6">
                        {{ __('employee.assign_task') }}: {{ $employee->full_name }}
                    </div>
                    <table class="min-w-full text-left text-sm font-light text-surface">
                        <thead class="border-b  font-medium ">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">{{ __('order.received_date') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('order.returned_date') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('employee.work_time') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('order.status') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('order.note') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('order.order_total_price') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($orders as $order)
                                <tr class="border-b  ">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $order->order_id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ formatDate($order->order_received_date, 'd-m-Y H:i') }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ formatDate($order->returned_date, 'd-m-Y H:i') }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex flex-wrap flex-col">
                                            <div>
                                                {{ formatDate($order->assignTask->first()->pivot->from_time ?? '', 'd-m-Y H:i') }}
                                            </div>
                                            <div class="text-center">
                                                -
                                            </div>
                                            <div>
                                                {{ formatDate($order->assignTask->first()->pivot->to_time ?? '', 'd-m-Y H:i') }}
                                            </div>

                                        </div>

                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 {{ orderStatusColor($order->order_status) }}">
                                        {{ $order->orderStatusName }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $order->order_note }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ formatNumber($order->order_total_price, 'VNĐ') }}</td>

                                    <td class="whitespace-nowrap flex gap-3 px-6 py-4">
                                        <div class="flex flex-wrap flex-col gap-4">
                                            <a
                                                href="{{ route('care-order-manage.show', ['care_order_manage' => $order->order_id]) }}">
                                                <button type="submit" class="btn btn-warning">
                                                    {{ __('Detail') }}
                                                </button>
                                            </a>

                                            @if ($order->assignTask->count() > 0 && $order->assignTask->first()->user_id == $userID)
                                                @include('employee.includes.update-assign-task-modal', [
                                                    'fromTime' => $order->assignTask->first()->pivot->from_time,
                                                    'toTime' => $order->assignTask->first()->pivot->to_time,
                                                    'order' => $order,
                                                ])

                                                <form
                                                    action="{{ route('employee.unassign-task', ['employee' => $userID, 'order' => $order->order_id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger">
                                                        {{ __('employee.unassign') }}
                                                    </button>
                                                </form>
                                            @elseif ($order->assignTask->count() > 0 && $order->assignTask->first()->user_id != $userID)
                                                <div class="text-blue-600 font-semibold">
                                                    {{ trans('Assigned To Other') }}
                                                </div>
                                            @elseif ($order->isAssignable())
                                                @include('employee.includes.assign-task-modal', [
                                                    'order' => $order,
                                                ])
                                            @endif
                                        </div>


                                    </td>

                                </tr>
                            @empty
                                @if (count($orders) == 0)
                                    <h4 class="text-center italic">{{ __('order.not_found') }}</h4>
                                @endif
                            @endforelse

                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
