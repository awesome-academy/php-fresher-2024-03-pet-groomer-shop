 <x-dropdown>
     <x-slot name="trigger">
         <x-icon.setting class="w-5 h-5 cursor-pointer " />
     </x-slot>

     <x-slot name="content">

         <div class="flex flex-wrap flex-col justify-center m-3 gap-3">
             <a href="{{ route('care-order-history.show', ['care_order_history' => $careOrder->order_id]) }}">
                 <button class="btn btn-sm btn-primary w-full">
                     {{ __('Detail') }}
                 </button>
             </a>

             @if ($careOrder->checkCancelable())
                 <button data-id="{{ $careOrder->order_id }}" class="btn btn-sm btn-danger care-order-cancel w-full">
                     {{ __('care-order.cancel') }}
                 </button>
             @endif

         </div>

     </x-slot>
 </x-dropdown>
