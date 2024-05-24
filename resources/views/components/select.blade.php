@props(['options', 'selected' => ''])

<select
    {{ $attributes->merge([
        'class' =>
            'block appearance-none w-full bg-white border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 px-4 py-[0.67rem] rounded shadow-sm leading-tight focus:outline-none focus:shadow-outline',
    ]) }}>
    @if (count($options) === 0)
        <option selected="selected" value="">{{ __('No options') }}</option>
    @else
        @foreach ($options as $label => $value)
            <option {{ $selected == $value ? 'selected="selected"' : '' }} value="{{ $value }}">
                {{ $label }}</option>
        @endforeach
    @endif

</select>
