<h3 class="text-xl text-bold mt-10 mb-4">
    {{ __('pet-service.pet_service') }}
</h3>
<div class="relative overflow-x-auto ">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    {{ trans('pet-service.name') }}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ trans('pet-service-price.price') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($petServices[0] as $petService)
                <tr class="bg-white border-b">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                        {{ $petService->pet_service_name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ formatNumber($petService->price, 'VND') }}
                    </td>
                </tr>
            @empty
                <tr class="bg-white border-b">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                        <i>{{ __('pet-service.not_found') }}</i>
                    </th>

                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="flex gap-3 mt-4 flex-wrap">
    <div>
        {{ trans('pet-service.total') }} : {{ formatNumber($petServices[1], 'VND') }}
    </div>


</div>
