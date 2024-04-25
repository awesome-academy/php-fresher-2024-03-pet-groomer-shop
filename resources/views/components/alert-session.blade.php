    @if (session('success'))
        <x-alert type="success" title="{{__('Success')}}" content="{{ session('success') }}" />
    @endif

    @if (session('info'))
        <x-alert type="info" title="{{__('Info')}}" content="{{ session('info') }}" />
    @endif

    @if (session('error'))
        <x-alert type="danger" title="{{__('Error')}}" content="{{ session('error') }}" />
    @endif

    @if (session('warning'))
        <x-alert type="warning" title="{{__('Warning')}}" content="{{ session('warning') }}" />
    @endif
