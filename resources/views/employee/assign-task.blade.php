<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-breadcrumb :items="$breadcrumbItems" />
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-alert-session />
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <table class="min-w-full text-left text-sm font-light text-surface ">
                        <thead class="border-b  font-medium ">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">{{ __('order.received_date') }}</th>
                                <th scope="col" class="px-6 py-4">{{ __('order.returned_date') }}</th>
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
                                        {{ formatDate($order->order_received_date, 'Y-m-d H:i') }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ formatDate($order->returned_date, 'Y-m-d H:i') }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ $order->orderStatusName }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ $order->order_note }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ formatNumber($order->order_total_price, 'VNĐ') }}</td>

                                    <td class="whitespace-nowrap flex gap-3 px-6 py-4">
                                        @if ($order->assignTask()->count() > 0)
                                            @include('employee.includes.update-assign-task-modal', [
                                                'fromTime' => $order->assignTask()->first()->pivot->from_time,
                                                'toTime' => $order->assignTask()->first()->pivot->to_time,
                                                'order' => $order,
                                            ])
                                        @else
                                            @include('employee.includes.assign-task-modal', [
                                                'order' => $order,
                                            ])
                                        @endif



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
