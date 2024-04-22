   @props(['items'])

   <div class="flex items-center space-x-2 text-sm">
       @foreach ($items as $index => $item)
           @if ($loop->last)
               <div class="font-semibold text-xl text-gray-500">{{ $item['text'] }}</div>
           @else
               <duv class="breadcrumb-item">
                   <a href="{{ $item['url'] }}" class="font-semibold text-xl text-blue-500  hover:underline">{{ $item['text'] }}</a>
               </duv>
               <div class="font-semibold text-xl breadcrumb-separator text-gray-400">/</div>
           @endif
       @endforeach
   </div>
