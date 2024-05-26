@props([
    'id' => '',
    'path' => '',
    'label' => '',
])

@if ($path ?? false)
    <img class="w-36 h-36 my-4 rounded-md shadow-sm" src="{{ asset('storage/' . $path) }}" alt="{{ $id }}">
@else
    <img class="w-36 h-36 my-4 rounded-md shadow-sm" src="{{ asset('img/default-image.png') }}" alt="default_img">
@endif
<x-label for="{{ $id }}" :value="__($label)" />

<input type="file" name="{{ $id }}" id="{{ $id }}" />
