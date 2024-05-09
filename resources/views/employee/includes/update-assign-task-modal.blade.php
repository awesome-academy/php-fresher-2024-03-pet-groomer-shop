 <x-modal :title="__('employee.assign_task')" :btnText="__('employee.assigned')" btnClass="btn-success">
     <form action="{{ route('employee.update-assign-task', ['employee' => $userID, 'order' => $order->order_id]) }}"
         method="POST">
         @csrf
         @method('PUT')
         <div class="flex flex-col flex-wrap md:grid grid-cols-12 gap-3 ">

             <div class="col-span-6">
                 <x-label required for="from_time" :value="__('From Time')" />

                 <x-input id="from_time" class="block mt-1 w-full" type="datetime-local" name="from_time" :value="$fromTime"
                     required autofocus />
             </div>
             <div class="col-span-6">
                 <x-label required for="to_time" :value="__('To Time')" />
                 <x-input required id="to_time" class="block mt-1 w-full" type="datetime-local" required
                     :value="$toTime" name="to_time" />

             </div>
         </div>

         <div>

             <x-modal-footer />
         </div>

     </form>
 </x-modal>
