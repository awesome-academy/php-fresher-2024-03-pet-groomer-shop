<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-breadcrumb :items="$breadcrumbItems" />
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST"
                        class="w-full flex flex-col
                    md:grid grid-cols-12 gap-2 md:gap-4"
                        action="{{ route('user.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-span-12">
                            <x-display-infor />
                        </div>

                        <div class="col-span-12">
                            <x-label for="user_name" :value="__('Avatar')" />
                            <input type="file" name="user_avatar" id="user_avatar">
                        </div>
                        <!-- First Name -->
                        <div class="col-span-6">
                            <x-label for="first_name" required :value="__('First Name')" />

                            <x-input id="first_name" class="block mt-1 w-full" type="text" name="user_first_name"
                                :value="old('user_first_name')" required autofocus />
                        </div>

                        <!-- Last Name -->
                        <div class="col-span-6">
                            <x-label for="last_name" required :value="__('Last Name')" />

                            <x-input id="last_name" class="block mt-1 w-full" type="text" name="user_last_name"
                                :value="old('user_last_name')" required autofocus />
                        </div>
                        <!-- Email Address -->
                        <div class="mt-4 col-span-6">
                            <x-label for="email" required :value="__('Email')" />

                            <x-input id="email" class="block mt-1 w-full" type="email" name="user_email"
                                :value="old('user_email')" required />
                        </div>

                        <!-- Username -->
                        <div class="mt-4 col-span-6">
                            <x-label for="username" required :value="__('Username')" />

                            <x-input id="username" class="block mt-1 w-full" type="text" name="username"
                                :value="old('username')" required autofocus />
                        </div>


                        <!-- Gender -->
                        <div class="col-span-6">
                            <x-label class="my-4 " for="male" :value="__('Gender')" />
                            <div class=" flex items-center justify-between w-full mt-4">
                                <div>
                                    <x-label for="male" class="inline-flex" :value="__('Male')" />

                                    <x-input id="male" class="" type="radio" checked name="user_gender"
                                        value="0" />
                                </div>

                                <div>
                                    <x-label for="female" class="inline-flex" :value="__('Female')" />

                                    <x-input id="female" class="" type="radio" name="user_gender"
                                        value="1" />
                                </div>


                                <div>
                                    <x-label for="other" class="inline-flex" :value="__('Other')" />

                                    <x-input id="other" class="" type="radio" name="user_gender"
                                        value="2" />
                                </div>


                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="mt-4 col-span-6">
                            <x-label for="phoneNumber" :value="__('Phone Number')" />

                            <x-input id="phoneNumber" class="block mt-1 w-full" type="text" name="user_phone_number"
                                :value="old('user_phone_number')" autofocus />
                        </div>

                        <!-- Address -->
                        <div class="mt-4 col-span-6">
                            <x-label for="address" :value="__('Address')" />

                            <x-input id="address" class="block mt-1 w-full" type="text" name="user_address"
                                :value="old('user_address')" autofocus />
                        </div>

                        <!-- Birthdate -->
                        <div class="mt-4 col-span-6">
                            <x-label for="birthdate" required :value="__('Birthdate')" />

                            <x-input id="birthdate" class="block mt-1 w-full" type="date" name="user_birthdate"
                                :value="old('user_birthdate')" autofocus />
                        </div>

                        <div class="mt-4 col-span-6">
                            <x-label for="password" required :value="__('Password')" />

                            <x-input id="password" class="block mt-1 w-full" type="password" name="user_password"
                                :value="old('user_password')" required autofocus />
                        </div>

                        <div class="mt-4 col-span-6">
                            <x-label for="password_confirmation" required :value="__('Confirm Password')" />

                            <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                name="user_password_confirmation" :value="old('user_password_confirmation')" required autofocus />
                        </div>

                        <div class="mt-4 col-span-6">
                            <x-label for="role" required :value="__('Role')" />

                            <x-select id="role" class="block mt-1 w-full" name="role_id" :options="$roles"
                                :value="old('role_id')" required autofocus />
                        </div>


                        <div class="mt-4 col-span-6">
                            <x-label for="branch" required :value="__('Branch')" />

                            <x-select id="branch" class="block mt-1 w-full" name="branch_id" :options="$branches"
                                :value="old('branch_id')" required autofocus />
                        </div>

                        <div class="col-span-6">
                            <x-label class="mb-4" required for="is_active" :value="__('Is Active')" />
                            <div class="flex w-5 h-5">
                                <x-input id="is_active" checked class="block mt-1 w-full" type="checkbox"
                                    name="is_active" :value="old('is_active')" />
                            </div>
                        </div>

                        <div class="col-span-12 flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Create') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
