 @props([
     'disableActionBtn' => false,
     'actionText' => 'OK',
 ])

 <div class="mt-5 flex gap-3 justify-end">
     <button @click="isOpen = false" type="button" class="btn btn-secondary">{{__('Close')}}</button>

     @if (!$disableActionBtn)
         <button type="submit" class="btn btn-primary">{{ $actionText }}</button>
     @endif
 </div>
