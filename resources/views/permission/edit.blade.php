 <x-modal :title="__('permission.update')" :btnText="__('Update')" btnClass="btn-sm">
     <form method="POST" class="w-full flex flex-col md:grid grid-cols-12 ga-2 md:gap-4"
         action="{{ route('permission.update', ['permission' => $permission['permission_id']]) }}">
         @csrf
         @method('PUT')
         <div class="col-span-6">
             <x-label required for="permission_name" :value="__('permission.name')" />

             <x-input id="permission_name" class="block mt-1 w-full" type="text" name="permission_name" :value="$permission->permission_name"
                 required autofocus />
         </div>


         </div>
         <x-modal-footer />

     </form>
 </x-modal>
