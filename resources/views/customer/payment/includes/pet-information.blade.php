    <h1 class="text-3xl font-semibold my-3 text-center">
        {{ __('payment.payment_for') . ' ' . $pet->pet_name }}
    </h1>

    <div class="my-3 font-medium text-gray-900">
        ⚖{{ trans('Pet Weight') }} : {{ $pet->weight_name }}
    </div>
    <div class="my-3 font-medium text-gray-900">
        🎂{{ trans('Pet Birthdate') }} : {{ formatDate($pet->pet_birthdate) }}
    </div>
    <hr>
