    <h1 class="text-3xl font-semibold my-3 text-center">
        {{ __('payment.payment_for') . ' ' . $pet->pet_name }}
    </h1>
    <div class="flex items-center gap-5">
        @if ($pet->image->image_path ?? false)
            <img class="w-36 h-36 my-4 rounded-md shadow-sm" src="{{ asset('storage/' . $pet->image->image_path) }}"
                alt="pet_avatar">
        @else
        @endif
        <div>
            <div class="my-3 font-medium text-gray-900">
                ⚖{{ trans('Pet Weight') }} : {{ $pet->weight_name }}
            </div>
            <div class="my-3 font-medium text-gray-900">
                🎂{{ trans('Pet Birthdate') }} : {{ formatDate($pet->pet_birthdate) }}
            </div>
        </div>

    </div>

    <hr>
