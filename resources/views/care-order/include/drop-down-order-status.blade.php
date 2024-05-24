 <x-dropdown :clickInside='true'>
     <x-slot name="trigger">
         <button class="btn btn-primary">{{ trans('order.status') }}</button>
     </x-slot>

     <x-slot name="content">

         <div class="flex flex-wrap flex-col justify-center m-3 gap-3">
             <x-select :selected="$careOrder->order_status" name="order_status_{{ $careOrder->order_id }}" class="w-full order_status_select"
                 :options="$orderStatusOptions" />

         </div>

     </x-slot>
 </x-dropdown>
