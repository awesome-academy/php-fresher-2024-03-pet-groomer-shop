 <x-modal :title="__('employee.assign_task')" :btnText="__('employee.assign_task')" btnClass="btn-sm">
     <form action="{{ route('employee.assign-task', ['employee' => $userID, 'order' => $order->order_id]) }}"
         method="POST">
         @csrf
         <div class="flex flex-col flex-wrap md:grid grid-cols-12 gap-3 ">
             <x-input id="order_received_date" class="block mt-1 w-full" type="hidden" name="order_received_date"
                 :value="$order->order_received_date" />
             <x-input id="returned_date" class="block mt-1 w-full" type="hidden" name="returned_date"
                 :value="$order->returned_date" />
             <div class="col-span-6">
                 <x-label required for="from_time" :value="__('From Time')" />

                 <x-input id="from_time" class="block mt-1 w-full" type="datetime-local" name="from_time"
                     :value="old('from_time')" required autofocus />
             </div>
             <div class="col-span-6">
                 <x-label required for="to_time" :value="__('To Time')" />
                 <x-input required id="to_time" class="block mt-1 w-full" type="datetime-local" required
                     name="to_time" />

             </div>
         </div>

         <div>

             <x-modal-footer />
         </div>

     </form>
 </x-modal>
