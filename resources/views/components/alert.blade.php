@props(['type' => 'info', 'content' => '', 'title' => 'Alert'])

@php
    $classes = [
        'info' => 'bg-blue-100 border-blue-400 text-blue-700',
        'success' => 'bg-green-100 border-green-400 text-green-700',
        'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
        'danger' => 'bg-red-100 border-red-400 text-red-700',
    ];
@endphp

<div class="border {{ $classes[$type] }} px-4 py-3 rounded relative" role="alert">
    <strong class="font-bold">{{ ucfirst($title) }}!</strong>
    <span class="block sm:inline">{{ $content }}</span>
</div>
