 <x-modal :title="__('role.update')" :btnText="__('Update')" btnClass="btn-sm">
     <form method="POST" class="w-full flex flex-col md:grid grid-cols-12 ga-2 md:gap-4"
         action="{{ route('role.update', ['role' => $role['role_id']]) }}">
         @csrf
         @method('PUT')
         <div class="col-span-6">
             <x-label required for="role_name" :value="__('role.name')" />

             <x-input id="role_name" class="block mt-1 w-full" type="text" name="role_name" :value="$role->role_name" required
                 autofocus />
         </div>


         </div>
         <x-modal-footer />

     </form>
 </x-modal>
