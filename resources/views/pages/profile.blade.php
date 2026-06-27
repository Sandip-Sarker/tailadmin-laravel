@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="User Profile" />

    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">

        {{-- ============================================================
             Profile Header (Avatar + Name + Edit Button)
             ============================================================ --}}
        <div class="mb-6 rounded-2xl border border-gray-200 p-5 lg:p-6 dark:border-gray-800">
            <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
                <div class="flex w-full flex-col items-center gap-6 xl:flex-row">
                    <div class="h-20 w-20 overflow-hidden rounded-full border border-gray-200 dark:border-gray-800">
                        <img
                            src="{{ Auth::user()?->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/user/owner.jpg') }}"
                            alt="user"
                            class="h-full w-full object-cover"
                        />
                    </div>
                    <div class="order-3 xl:order-2">
                        <h4 class="mb-2 text-center text-lg font-semibold text-gray-800 xl:text-left dark:text-white/90">
                            {{ Auth::user()->name ?? '' }}
                        </h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Role: {{ Auth::user()->role ?? '' }}
                        </p>
                    </div>
                </div>

                {{-- Edit Button --}}
                <button id="openProfileModalBtn"
                    class="shadow-theme-xs flex w-full items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 lg:inline-flex lg:w-auto dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                    <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206Z"
                            fill="" />
                    </svg>
                    Edit
                </button>
            </div>
        </div>

        {{-- ============================================================
             Edit Profile Modal  (same structure as user create form)
             ============================================================ --}}
        <div id="profileEditModal" class="fixed inset-0 z-99999 hidden flex items-center justify-center overflow-y-auto p-5">
            <!-- Backdrop -->
            <div class="profile-modal-close fixed inset-0 h-full w-full bg-gray-400/50 dark:bg-gray-900/50 backdrop-blur-[32px]"></div>

            <!-- Modal Content -->
            <div class="relative w-full max-w-[700px] rounded-3xl bg-white dark:bg-gray-900 shadow-2xl z-10">
                <!-- Close Button -->
                <button type="button" class="profile-modal-close absolute right-3 top-3 z-999 flex h-9.5 w-9.5 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white sm:right-6 sm:top-6 sm:h-11 sm:w-11">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.04289 16.5413C5.65237 16.9318 5.65237 17.565 6.04289 17.9555C6.43342 18.346 7.06658 18.346 7.45711 17.9555L11.9987 13.4139L16.5408 17.956C16.9313 18.3466 17.5645 18.3466 17.955 17.956C18.3455 17.5655 18.3455 16.9323 17.955 16.5418L13.4129 11.9997L17.955 7.4576C18.3455 7.06707 18.3455 6.43391 17.955 6.04338C17.5645 5.65286 16.9313 5.65286 16.5408 6.04338L11.9987 10.5855L7.45711 6.0439C7.06658 5.65338 6.43342 5.65338 6.04289 6.0439C5.65237 6.43442 5.65237 7.06759 6.04289 7.45811L10.5845 11.9997L6.04289 16.5413Z" fill="currentColor" />
                    </svg>
                </button>

                <!-- Modal Body -->
                <div class="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11">
                    <div class="px-2 pr-14">
                        <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
                            Edit Personal Information
                        </h4>
                        <p class="mb-6 text-sm text-gray-500 dark:text-gray-400 lg:mb-7">
                            Update your details to keep your profile up-to-date.
                        </p>
                    </div>

                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="flex flex-col">
                        @csrf
                        @method('patch')

                        <div class="custom-scrollbar h-[458px] overflow-y-auto p-2">
                            <div class="mt-2">
                                <h5 class="mb-5 text-lg font-medium text-gray-800 dark:text-white/90 lg:mb-6">
                                    Profile Image
                                </h5>
                                {{-- <div>
                                    <input
                                        id="profile_avatar"
                                        name="avatar"
                                        type="file"
                                        accept="image/*"
                                        class="dropify"
                                        data-height="150"
                                        data-default-file="{{ Auth::user()?->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/user/owner.jpg') }}"
                                        data-max-file-size="2M"
                                        data-allowed-file-extensions="jpg jpeg png gif webp"
                                        data-show-remove="true"
                                    />
                                    @error('avatar')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div> --}}

                                <div class="col-span-2 lg:col-span-1">
                                        <label for="profile_avatar" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            Avatar
                                        </label>
                                        <input id="profile_avatar" name="avatar" type="file"
                                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
                                            />
                                        @error('avatar')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                </div>
                            </div>

                            <div class="mt-8">
                                <h5 class="mb-5 text-lg font-medium text-gray-800 dark:text-white/90 lg:mb-6">
                                    Personal Information
                                </h5>
                                <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">
                                    <div class="col-span-2 lg:col-span-1">
                                        <label for="profile_name" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            Name
                                        </label>
                                        <input id="profile_name" name="name" type="text"
                                            value="{{ old('name', Auth::user()->name ?? '') }}"
                                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
                                            required />
                                        @error('name')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-2 lg:col-span-1">
                                        <label for="profile_email" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            Email
                                        </label>
                                        <input id="profile_email" name="email" type="email"
                                            value="{{ old('email', Auth::user()->email ?? '') }}"
                                            class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
                                            required />
                                        @error('email')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-span-2">
                                        <label for="profile_role" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                            Role
                                        </label>
                                        <select id="profile_role" name="role" disabled
                                            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-gray-100 dark:bg-gray-800 cursor-not-allowed px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:focus:border-brand-800">
                                            <option value="{{ Auth::user()->role }}" selected>{{ Auth::user()->role }}</option>
                                        </select>
                                        <p class="mt-1 text-xs text-gray-400">Role cannot be changed directly from personal profile editor.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 px-2 mt-6 lg:justify-end">
                            <button type="button" class="profile-modal-close flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] sm:w-auto">
                                Close
                            </button>
                            <button type="submit"
                                class="flex w-full justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 sm:w-auto">
                                Save Changes
                            </button>
                        </div>

                        @if (session('status') === 'profile-updated')
                            <p class="mt-4 text-sm text-green-600 dark:text-green-400">Your profile has been updated.</p>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        {{-- ============================================================
             Tab Navigation — Alpine.js x-data (no JS function needed)
             ============================================================ --}}
        <div class="mt-2" x-data="{ activeTab: '{{ session('status') === 'password-updated' || $errors->updatePassword->any() ? 'password' : 'profile' }}' }">

            {{-- Tab Buttons --}}
            <div class="relative mb-6 flex border-b border-gray-200 dark:border-gray-700">

                {{-- Profile Info Tab Button --}}
                <button @click="activeTab = 'profile'"
                    :class="activeTab === 'profile'
                        ? 'border-brand-500 text-brand-500 dark:text-brand-400'
                        : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                    class="flex items-center gap-2 border-b-2 px-4 py-3 text-sm font-medium transition-colors duration-200 focus:outline-none">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profile Info
                </button>

                {{-- Change Password Tab Button --}}
                <button @click="activeTab = 'password'"
                    :class="activeTab === 'password'
                        ? 'border-brand-500 text-brand-500 dark:text-brand-400'
                        : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'"
                    class="flex items-center gap-2 border-b-2 px-4 py-3 text-sm font-medium transition-colors duration-200 focus:outline-none">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Change Password
                    @if($errors->updatePassword->any())
                        <span class="ml-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white">!</span>
                    @endif
                </button>
            </div>

            {{-- ======================================================
                 Tab Content: Profile Info
                 ====================================================== --}}
            {{-- Profile Info Tab Content --}}
            <div x-show="activeTab === 'profile'" x-transition>
                <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">
                                Personal Information
                            </h4>
                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7 2xl:gap-x-32 mt-4">
                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Name</p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ Auth::user()->name ?? '' }}</p>
                                </div>
                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">Email address</p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ Auth::user()->email ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Change Password Tab Content --}}
            <div x-show="activeTab === 'password'" x-transition>
                <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">Change Password</h4>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Update your password to keep your account secure. Use at least 8 characters.
                        </p>
                    </div>

                    {{-- Success Alert --}}
                    @if (session('status') === 'password-updated')
                        <div class="mb-5 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 dark:border-green-700/40 dark:bg-green-900/20">
                            <svg class="h-5 w-5 flex-shrink-0 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm font-medium text-green-700 dark:text-green-400">Password updated successfully!</p>
                        </div>
                    @endif

                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">

                            {{-- Current Password --}}
                            <div class="col-span-2">
                                <label for="current_password" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Current Password
                                </label>
                                <div class="relative">
                                    <input
                                        id="current_password"
                                        name="current_password"
                                        type="password"
                                        autocomplete="current-password"
                                        placeholder="Enter your current password"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:outline-hidden focus:ring-3 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30
                                            {{ $errors->updatePassword->has('current_password') ? 'border-red-400 focus:border-red-400 focus:ring-red-500/10' : 'border-gray-300 focus:border-brand-300 focus:ring-brand-500/10 dark:border-gray-700 dark:focus:border-brand-800' }}"
                                    />
                                    <button type="button" onclick="togglePassword('current_password', this)"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                                @error('current_password', 'updatePassword')
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- New Password --}}
                            <div class="col-span-2 lg:col-span-1">
                                <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    New Password
                                </label>
                                <div class="relative">
                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        autocomplete="new-password"
                                        placeholder="Min. 8 characters"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:outline-hidden focus:ring-3 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30
                                            {{ $errors->updatePassword->has('password') ? 'border-red-400 focus:border-red-400 focus:ring-red-500/10' : 'border-gray-300 focus:border-brand-300 focus:ring-brand-500/10 dark:border-gray-700 dark:focus:border-brand-800' }}"
                                    />
                                    <button type="button" onclick="togglePassword('password', this)"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                                @error('password', 'updatePassword')
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-span-2 lg:col-span-1">
                                <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Confirm New Password
                                </label>
                                <div class="relative">
                                    <input
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        type="password"
                                        autocomplete="new-password"
                                        placeholder="Re-enter new password"
                                        class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
                                    />
                                    <button type="button" onclick="togglePassword('password_confirmation', this)"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                        </div>

                        {{-- Password Strength Tips --}}
                        <div class="mt-5 rounded-xl border border-gray-100 bg-gray-50 p-4 dark:border-gray-700 dark:bg-white/[0.03]">
                            <p class="mb-2 text-xs font-medium text-gray-600 dark:text-gray-400">Password requirements:</p>
                            <ul class="space-y-1">
                                <li class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                    <svg class="h-3.5 w-3.5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    At least 8 characters long
                                </li>
                                <li class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                    <svg class="h-3.5 w-3.5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Contains letters, numbers or special characters
                                </li>
                                <li class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                    <svg class="h-3.5 w-3.5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    New password must match the confirmation
                                </li>
                            </ul>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-6 py-2.5 text-sm font-medium text-white shadow-sm transition-colors duration-200 hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
<script>
    // ============================================================
    // Profile Modal — Open / Close (jQuery, same as user modal)
    // ============================================================
    function initProfileDropify() {
        if (typeof $.fn.dropify !== 'undefined') {
            var input = $('#profile_avatar');
            
            // Clean up existing dropify structure
            var dr = input.data('dropify');
            if (dr) { 
                dr.destroy(); 
            }
            
            // Ensure the input has the correct default-file attribute
            var defaultFile = "{{ Auth::user()?->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/user/owner.jpg') }}";
            input.attr('data-default-file', defaultFile);

            // Re-instantiate dropify so it reads the data-default-file and builds correctly
            input.dropify({
                defaultFile: defaultFile,
                messages: {
                    default: 'Drag & drop or click to upload',
                    replace: 'Drag & drop or click to replace',
                    remove:  'Remove',
                    error:   'An error occurred. Please try again.'
                }
            });
        }
    }

    $('#openProfileModalBtn').on('click', function () {
        $('#profileEditModal').removeClass('hidden').addClass('flex');
        $('body').css('overflow', 'hidden');
        initProfileDropify();
    });

    $(document).on('click', '.profile-modal-close', function () {
        $('#profileEditModal').addClass('hidden').removeClass('flex');
        $('body').css('overflow', 'unset');
    });

    // Close on backdrop click
    $(document).on('click', '#profileEditModal', function (e) {
        if ($(e.target).is('#profileEditModal')) {
            $('#profileEditModal').addClass('hidden').removeClass('flex');
            $('body').css('overflow', 'unset');
        }
    });

    {{-- Auto-open modal if profile errors exist --}}
    @if ($errors->has('name') || $errors->has('email') || $errors->has('avatar'))
        $(function () {
            $('#profileEditModal').removeClass('hidden').addClass('flex');
            $('body').css('overflow', 'hidden');
            initProfileDropify();
        });
    @endif

    // ============================================================
    // Dropify Init
    // ============================================================
    $(document).ready(function () {
        if (typeof $.fn.dropify !== 'undefined') {
            // Initialize Dropify on page load (even if hidden, but we will re-init it on modal open)
            var dropifyInput = $('#profile_avatar').dropify({
                messages: {
                    default: 'Drag & drop or click to upload',
                    replace: 'Drag & drop or click to replace',
                    remove:  'Remove',
                    error:   'An error occurred. Please try again.'
                }
            });
        }
    });

    // ============================================================
    // Password Show / Hide Toggle
    // ============================================================
    function togglePassword(fieldId, btn) {
        var input = document.getElementById(fieldId);
        var isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        var svg = btn.querySelector('svg');
        if (isPassword) {
            svg.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            `;
        } else {
            svg.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    }
</script>
@endpush
