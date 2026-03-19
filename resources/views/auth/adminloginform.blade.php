@extends('layout.secondary')

@section('main-content')
    <div class="min-h-screen flex items-center justify-center py-8 px-4">
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">

            <!-- Left Side - Admin Form -->
            <div class="p-8 lg:p-12 flex flex-col justify-center">

                <!-- Admin Badge -->
                <div class="mb-4">
                    <span
                        class="inline-block px-4 py-1 text-sm font-semibold rounded-full
                             bg-danger-100 text-danger-600">
                        ADMIN ACCESS ONLY
                    </span>
                </div>

                <div class="mb-6">
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-2">
                        Admin Login
                    </h1>
                    <p class="text-gray-600">
                        Sign in to manage NIC-Quiz system
                    </p>
                </div>

                <!-- Error Message -->
                @if (session('error'))
                    <div class="mb-6 px-4 py-3 bg-danger-100 border-l-4 border-danger-500 text-danger-700 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login.admin.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Username -->
                    <div>
                        <x-label for="username" class="text-gray-700 font-semibold mb-2">
                            Username
                        </x-label>
                        <x-form-input type="text" name="username" placeholder="Admin username" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-label for="password" class="text-gray-700 font-semibold mb-2">
                            Password
                        </x-label>
                        <x-form-input type="password" name="password" placeholder="Admin password" />
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full py-3 rounded-xl font-semibold text-white
                           bg-danger-600 hover:bg-danger-700 transition">
                        Login as Admin
                    </button>
                </form>

                <!-- Back to User Login -->
                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-700">
                        ← Back to user login
                    </a>
                </div>
            </div>

            <!-- Right Side - Admin Illustration -->
            <div
                class="hidden lg:flex bg-gradient-to-br from-danger-600 to-danger-500
                   p-12 flex-col items-center justify-center text-white relative">

                <!-- Icon -->
                <div class="mb-6">
                    <div
                        class="w-24 h-24 rounded-2xl bg-white/20
                           flex items-center justify-center shadow-xl">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2a5 5 0 00-5 5v3H6a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2v-8a2 2 0 00-2-2h-1V7a5 5 0 00-5-5zm-3 8V7a3 3 0 016 0v3H9z" />
                        </svg>
                    </div>
                </div>

                <h2 class="text-3xl font-bold mb-2">System Administration</h2>
                <p class="text-white/90 text-center max-w-xs">
                    Manage users, courses, and classrooms
                </p>
            </div>

        </div>
    </div>
@endsection
