@extends('layout.secondary')

@section('main-content')
    <div class="min-h-screen flex items-center justify-center py-8 px-4">
        <div class="w-full max-w-5xl bg-white    rounded-2xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">

            <!-- Left Side - Form -->
            <div class="p-8 lg:p-12 flex flex-col justify-center">
                <div class="mb-6">
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-2">Welcome Back!</h1>
                    <p class="text-gray-600">Sign in to continue to NIC-Quiz</p>
                </div>

                <!-- Error Message -->
                @if (session('error'))
                    <div class="mb-6 px-4 py-3 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('login.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Username Field -->
                    <div>
                        <x-label for="username" class="text-gray-700 font-semibold mb-2">Username</x-label>
                        <x-form-input
                            type="text"
                            name="username"
                            placeholder="Enter your username"
                        />
                    </div>

                    <!-- Password Field -->
                    <div>
                        <x-label for="password" class="text-gray-700 font-semibold mb-2">Password</x-label>
                        <x-form-input
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                        />
                    </div>

                    <!-- Submit Button -->
                    <x-submit-button class="w-full">
                        Sign In
                    </x-submit-button>
                </form>

                <!-- Admin Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Are you an admin?
                        <a href="{{ route('login.admin') }}" class="text-secondary-400 hover:text-secondary-500 font-semibold">Login here</a>
                    </p>
                </div>
            </div>

            <!-- Right Side - Illustration/Logo -->
            <div class="hidden lg:flex bg-gradient-to-br from-secondary-400 to-secondary-300 p-12 flex-col items-center justify-center text-white relative overflow-hidden">

                <!-- Decorative Waves Background -->
                <div class="absolute inset-0 opacity-20">
                    <svg class="absolute bottom-0 w-full" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#ffffff" fill-opacity="0.3" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                    </svg>
                </div>

                <!-- Logo/Illustration Content -->
                <div class="relative z-10 text-center">
                    <!-- School Logo Placeholder -->
                    <div class="mb-8">
                        <div class="w-32 h-32 mx-auto bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border-4 border-white/30">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Text Content -->
                    <h2 class="text-4xl font-bold mb-4">NIC-Quiz</h2>
                    <p class="text-lg mb-8 text-white/90">Smart Testing Platform</p>

                    <!-- Features List -->
                    <div class="space-y-4 text-left max-w-xs mx-auto">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-white/90">Easy to use interface</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-white/90">Real-time grading</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-white/90">Comprehensive analytics</span>
                        </div>
                    </div>
                </div>

                <!-- Decorative Elements -->
                <div class="absolute top-10 right-10 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
                <div class="absolute bottom-20 left-10 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
            </div>

        </div>
    </div>
@endsection
