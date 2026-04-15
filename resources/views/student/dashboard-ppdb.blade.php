@extends('layout.main')

@section('main-content')
    <div class="p-6">
        {{-- Welcoming Header --}}
        <div class="bg-secondary-400 rounded-lg shadow-xl shadow-gray-400 text-center px-6 py-12 relative overflow-hidden">
            <div class="absolute top-0 left-0">
                <svg class="w-48 h-48" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="white" fill-opacity="0.1" d="M 0 0 L 200 0 L 0 200 Z" />
                    <path fill="white" fill-opacity="0.05" d="M 0 0 L 120 0 L 0 120 Z" />
                </svg>
            </div>
            <div class="relative">
                <h1 class="text-success-400 text-4xl md:text-5xl font-bold tracking-tight">
                    Selamat Datang
                </h1>
                <p class="text-white text-lg md:text-xl mt-2 mb-4">
                    Calon Siswa dan Siswi Baru
                </p>
                <p class="text-3xl md:text-4xl font-extrabold">
                    <span class="text-white">MTs</span>
                    <span class="text-white">Nurul Islam Cisauk</span>
                </p>
            </div>
        </div>
        {{-- Important Information Card --}}

        @if (auth()->user()->hasDefaultPassword())
            <x-alert.default-password></x-alert.default-password>
        @endif

    </div>
@endsection
