<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-500 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="my-3">
                        <x-display-infor />
                    </div>
                    <form method="POST" class="w-full grid grid-cols-12 gap-4"
                        action="{{ route('customer-profile.update', ['customer_profile' => $user->user_id]) }}"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="col-span-12">

                            @if ($user->image->image_path ?? false)
                                <img class="w-36 h-36 my-4 rounded-md shadow-sm"
                                    src="{{ asset('storage/' . $user->image->image_path) }}" alt="user_avatar">
                            @else
                                <img class="w-36 h-36 my-4 rounded-md shadow-sm" src="{{ asset('img/default-image.png') }}"
                                    alt="user_avatar">
                            @endif
                            <x-label for="user_avatar" :value="__('Avatar')" />

                            <input type="file" name="user_avatar" id="user_avatar">
                        </div>

                        <div class="col-span-6">
                            <x-label for="first_name" required :value="__('First Name')" />

                            <x-input id="first_name" class="block mt-1 w-full" type="text" name="user_first_name"
                                :value="$user->user_first_name" required autofocus />
                        </div>

                        <!-- Last Name -->
                        <div class="col-span-6">
                            <x-label for="last_name" required :value="__('Last Name')" />

                            <x-input id="last_name" class="block mt-1 w-full" type="text" name="user_last_name"
                                :value="$user->user_last_name" required autofocus />
                        </div>
                        <!-- Email Address -->
                        <div class="mt-4 col-span-6">
                            <x-label for="email" :value="__('Email')" />

                            <x-input id="email" class="block mt-1 w-full" type="email" name="user_email"
                                :value="$user->user_email" disabled required />
                        </div>

                        <!-- Username -->
                        <div class="mt-4 col-span-6">
                            <x-label for="username" :value="__('Username')" />

                            <x-input id="username" disabled class="block mt-1 w-full" type="text" name="username"
                                :value="$user->username" required autofocus />
                        </div>


                        <!-- Gender -->
                        <div class="col-span-6">
                            <x-label class="my-4 " for="male" :value="__('Gender')" />
                            <div class=" flex items-center justify-between w-full mt-4">
                                <div>
                                    <x-label for="male" class="inline-flex" :value="__('Male')" />
                                    <x-input id="male" :checked="$user->user_gender == 0" type="radio" name="user_gender"
                                        value="0" />
                                </div>

                                <div>
                                    <x-label for="female" class="inline-flex" :value="__('Female')" />
                                    <x-input id="female" :checked="$user->user_gender == 1" class="" type="radio"
                                        name="user_gender" value="1" />
                                </div>


                                <div>
                                    <x-label for="other" class="inline-flex" :value="__('Other')" />

                                    <x-input id="other" :checked="$user->user_gender == 2" class="" type="radio"
                                        name="user_gender" value="2" />
                                </div>


                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="mt-4 col-span-6">
                            <x-label for="phoneNumber" :value="__('Phone Number')" />

                            <x-input id="phoneNumber" :value="$user->user_phone_number" class="block mt-1 w-full"
                                name="user_phone_number" type="text" autofocus />
                        </div>

                        <!-- Address -->
                        <div class="mt-4 col-span-6">
                            <x-label for="address" :value="__('Address')" />

                            <x-input id="address" :value="$user->user_address" class="block mt-1 w-full" type="text"
                                name="user_address" autofocus />
                        </div>

                        <!-- Birthdate -->
                        <div class="mt-4 col-span-6">
                            <x-label for="birthdate" :value="__('Birthdate')" />

                            <x-input id="birthdate" :value="$user->user_birthdate" class="block mt-1 w-full" type="date"
                                name="user_birthdate" autofocus />
                        </div>


                        <div class="col-span-12 flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</x-customer-layout>
