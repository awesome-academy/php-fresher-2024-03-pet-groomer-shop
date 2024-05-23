<div class="swal-icon swal-icon--success">
    <span class="swal-icon--success__line swal-icon--success__line--long"></span>
    <span class="swal-icon--success__line swal-icon--success__line--tip"></span>
    <div class="swal-icon--success__ring"></div>
    <div class="swal-icon--success__hide-corners"></div>
</div>
<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6 border-b">
                    <div class="success-checkmark">
                        <div class="check-icon">
                            <span class="icon-line line-tip"></span>
                            <span class="icon-line line-long"></span>
                            <div class="icon-circle"></div>
                            <div class="icon-fix"></div>
                        </div>
                    </div>

                    <div class="text-center my-4 text-3xl font-bold">
                        {{ trans('payment.success') }}
                    </div>
                    <div class="my-4 flex justify-center">
                        <a href="{{ route('home') }}">
                            <button class="btn btn-primary">{{ trans('Go Home') }}</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
