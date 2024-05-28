@props([
    'id' => '',
    'path' => '',
    'label' => '',
    'dataID' => '',
])

@if ($path ?? false)
    <img id="review-image{{$dataID}}" class="w-36 h-36 my-4 border-2 rounded-3xl shadow-xl"
        src="{{ asset('storage/' . $path) }}" alt="{{ $id }}">
@else
    <img id="review-image{{$dataID}}" class="w-36 h-36 my-4 rounded-md shadow-sm"
        src="{{ asset('img/default-image.png') }}" alt="default_img">
@endif
<x-label for="{{ $id }}" :value="__($label)" />

<input data-id="{{ $dataID }}" type="file" class="{{ $id }}" name="{{ $id }}" id="{{ $id }}" />
