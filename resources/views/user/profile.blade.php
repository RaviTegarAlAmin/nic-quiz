@extends('layout.main')

@section('main-content')
    <div class="w-full" x-data="{
        showPasswordForm: false,
        showOld: false,
        showNew: false,
        showConfirm: false,
        newPassword: '',
        confirmPassword: '',
        toast: false,
        type: 'success',
        message: '',
        showToast(type, message) {
            this.type = type;
            this.message = message;
            this.toast = true;
        }
    }">
        <x-toast />
        @if (session('success'))
            <div x-init="showToast('success', '{{ session('success') }}')"></div>
        @endif
        @if (session('error'))
            <div x-init="showToast('failed', '{{ session('error') }}')"></div>
        @endif
        <!-- Header -->
        <x-header
            class="mb-8 bg-gradient-to-r from-secondary-400 to-secondary-300 text-white border-none rounded-lg shadow-lg px-6 py-4">
            User Profile
        </x-header>

        <!-- Profile Section -->
        <div class="max-w-2xl mx-auto">
            <div class="relative flex flex-col items-center w-full">
                <!-- Circle Photo -->
                <div class="relative z-10 -mb-20">
                    <div
                        class="w-40 h-40 rounded-full border-4 border-secondary-400 bg-gray-100 overflow-hidden shadow-xl ring-4 ring-white">
                        <img src="{{ asset('Assets/Logo/default-profile.png') }}" class="object-cover w-full h-full"
                            alt="User Photo">
                    </div>
                </div>

                <!-- Info Card -->
                <div class="relative w-full">
                    <x-card
                        class="w-full pt-24 px-6 pb-8 text-gray-700 shadow-lg border-t-4 border-secondary-400 hover:shadow-xl transition-shadow duration-200">
                        <div class="text-center">
                            <h2 class="text-2xl font-bold mb-1 text-gray-800">{{ auth()->user()->getUserProfileName() }}
                            </h2>
                            <p class="text-sm text-gray-500">{{ auth()->user()->getUserIdentifier() }}</p>
                            @if ($profile)
                                @if ($profile instanceof \App\Models\Teacher)
                                    <p class="text-sm text-gray-500">NIP: {{ $profile->nip }}</p>
                                @elseif($profile instanceof \App\Models\Student)
                                    <p class="text-sm text-gray-500">NIS: {{ $profile->nis }}</p>
                                @endif
                                <p class="text-sm text-gray-500">{{ $profile->address }}</p>
                                <p class="text-sm text-gray-500 mb-8">
                                    {{ $profile->born_date ? \Carbon\Carbon::parse($profile->born_date)->format('d F Y') : '' }}
                                </p>
                            @endif
                        </div>

                        <div class="flex justify-center">
                            <x-button variant="secondary" @click="showPasswordForm = !showPasswordForm">
                                Ubah Password
                            </x-button>
                        </div>
                    </x-card>
                </div>
            </div>

            <!-- Change Password Form -->
            <div x-show="showPasswordForm" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-6" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-6" class="mt-8" style="display: none;">
                <x-card>
                    <h3 class="text-lg font-semibold mb-4 border-b pb-3">
                        @if (auth()->user()->hasDefaultPassword())
                            Set Password Baru
                        @else
                            Ubah Password
                        @endif
                    </h3>
                    <form action="{{ route('user.password.change') }}" method="POST" class="mt-4 space-y-4">
                        @csrf
                        @method('PATCH')

                        @if (!auth()->user()->hasDefaultPassword())
                            <div class="space-y-1">
                                <x-label for="oldpassword">Password Lama</x-label>
                                <div class="relative">
                                    <x-form-input ::type="showOld ? 'text' : 'password'" name="oldpassword" id="oldpassword"
                                        class="w-full pr-10" required />
                                    <button type="button" @click.prevent="showOld = !showOld"
                                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600">
                                        <svg x-show="!showOld" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        <svg x-show="showOld" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49" />
                                            <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242" />
                                            <path
                                                d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143" />
                                            <path d="m2 2 20 20" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif

                        <div class="space-y-1">
                            <x-label for="newpassword">Password Baru</x-label>
                            <div class="relative">
                                <x-form-input ::type="showNew ? 'text' : 'password'" name="newpassword" id="newpassword"
                                    class="w-full pr-10" required x-model="newPassword" />
                                <button type="button" @click.prevent="showNew = !showNew"
                                     class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600">
                                    <svg x-show="!showNew" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    <svg x-show="showNew" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49" />
                                        <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242" />
                                        <path
                                            d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143" />
                                        <path d="m2 2 20 20" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <x-label for="newpassword_confirmation">Konfirmasi Password Baru</x-label>
                            <div class="relative">
                                <x-form-input ::type="showConfirm ? 'text' : 'password'" name="newpassword_confirmation"
                                    id="newpassword_confirmation" class="w-full pr-10" required x-model="confirmPassword" />
                                <button type="button" @click.prevent="showConfirm = !showConfirm"
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600">
                                    <svg x-show="!showConfirm" xmlns="http://www.w3.org/2000/svg" width="20"
                                        height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    <svg x-show="showConfirm" xmlns="http://www.w3.org/2000/svg" width="20"
                                        height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49" />
                                        <path d="M14.084 14.158a3 3 0 0 1-4.242-4.242" />
                                        <path
                                            d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143" />
                                        <path d="m2 2 20 20" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-end items-center pt-2 gap-4">
                            <p x-show="newPassword !== confirmPassword && confirmPassword.length > 0"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                class="text-danger-500 text-xs font-semibold">
                                Konfirmasi password tidak cocok.
                            </p>
                            <x-button type="submit" variant="success"
                                ::disabled="newPassword !== confirmPassword && newPassword.length > 0">
                                Simpan
                            </x-button>
                        </div>
                    </form>
                </x-card>
            </div>
        </div>
    </div>
@endsection
