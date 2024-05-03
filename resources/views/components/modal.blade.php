@props([
    'title' => 'Modal Title',
    'btnText' => 'Open Modal',
    'btnClass' => '',
    'titleClass' => '',
    'contentClass' => '',
])

<div x-data="{ isOpen: false, className: 'hidden inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50' }">
    <!-- Trigger Button -->
    <button @click="isOpen = true, className = 'fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50'"
        class="{{ 'btn btn-primary text-white font-bold py-2 px-4 rounded' . ' ' . $btnClass }}">
        {{ $btnText }}
    </button>

    <!-- Modal Background -->
    <div x-show="isOpen" x-bind:class="className" x-cloak>
        <!-- Modal Content -->
        <div class="bg-white text-black rounded p-8 w-1/2">
            <div class="flex items-center justify-between mb-4">
                <!-- Modal Content Here -->
                <h2 class="{{ 'text-lg font-semibold' . ' ' . $titleClass }}">{{ $title }}</h2>
                <!-- Close Button -->
                <button @click="isOpen = false" class="btn btn-text text-black">&times;</button>


            </div>
            <div :class="$contentClass">
                {{ $slot }}
            </div>

        </div>
    </div>
</div>
