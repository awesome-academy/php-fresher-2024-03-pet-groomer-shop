 <x-dropdown clickInside="true">
     <x-slot name="trigger">
         <div id="has-notification-icon">
             <x-icon.has-notification class="w-4 h-4 cursor-pointer " />
         </div>
         <div id="notification-icon">
             <x-icon.notification class="w-4 h-4 cursor-pointer " />
         </div>
     </x-slot>

     <x-slot name="content">

         <div class="flex flex-wrap flex-col gap-3 p-2" id="notify-list">

         </div>

     </x-slot>
 </x-dropdown>
