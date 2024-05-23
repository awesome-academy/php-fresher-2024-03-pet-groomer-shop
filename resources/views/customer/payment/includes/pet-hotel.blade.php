<h3 class="text-xl text-bold mt-10 mb-4">
    {{ __('hotel-service.hotel_service') }}
</h3>
<div class="  flex md:grid grid-cols-12 flex-wrap gap-5 ">
    @if (isset($careOrder['from_datetime']) && isset($careOrder['to_datetime']))
        <div class="col-span-6">
            <x-label for="from_datetime" :value="__('From Time')" />
            <x-input id="from_datetime" disabled :value="$careOrder['from_datetime']" class="block mt-1 w-full" type="datetime-local"
                name="from_datetime" />
        </div>
        <div class="col-span-6">
            <x-label for="to_datetime" :value="__('To Time')" />
            <x-input id="to_datetime" disabled :value="$careOrder['to_datetime']" class="block mt-1 w-full" type="datetime-local"
                name="to_datetime" />
        </div>
        <div class="col-span-12">
            <div class="flex gap-3 flex-wrap">
                <div>
                    {{ trans('hotel-service.hours') }} : {{ $hotel[1] }}
                </div>
                <div>
                    {{ trans('hotel-service.price') }} : {{ formatNumber($hotel[0], 'VND') }}
                </div>

            </div>
        </div>
    @else
        <i class="col-span-12">{{ __('hotel-service.not_found') }}</i>
    @endif
</div>
