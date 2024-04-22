 @props([
     'disableActionBtn' => false,
     'actionText' => 'OK',
 ])

 <div class="mt-5 flex gap-3 justify-end">
     <button @click="isOpen = false" class="btn btn-secondary">Close</button>

     @if (!$disableActionBtn)
         <button @click="isOpen = false" type="submit" class="btn btn-primary">{{ $actionText }}</button>
     @endif
 </div>
