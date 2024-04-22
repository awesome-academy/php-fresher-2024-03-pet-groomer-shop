@props(['value', 'required' => false])

@php
    $getRequired = $required ? ' *' : '';
@endphp

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
    {{ $value . $getRequired ?? $slot }}
</label>
