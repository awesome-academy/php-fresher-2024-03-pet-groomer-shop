@props(['rows' => 3])

<textarea
    {{ $attributes->merge(['class' => 'block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-400']) }}
    rows="{{ $rows }}"></textarea>
