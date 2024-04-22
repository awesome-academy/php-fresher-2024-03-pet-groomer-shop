@props(['disabled' => false, 'checked' => false])

@php
    $disableClass = $disabled ? ' bg-gray-200 opacity-80' : '';
@endphp

<input {{ $checked ? 'checked' : '' }} {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50' .
        $disableClass,
]) !!}>
