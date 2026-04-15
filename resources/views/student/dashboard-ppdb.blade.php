@extends('layout.main')

@section('main-content')
    <div class="p-6 pt-3">
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

        {{-- Exam Procedure --}}


        {{-- Important Information Card --}}

        @if (auth()->user()->hasDefaultPassword())
            <x-alert.default-password></x-alert.default-password>
        @endif

        <h2 class=" text-center font-bold text-3xl text-warning-600 mt-6 mb-6">
            Perhatian!
        </h2>

        <x-card>
            <ul class=" odd:text-gray-500 list-disc ml-6">
                <li>
                    Segera ganti password default
                </li>
                <li>
                    Masuk ke menu <span class=" font-bold">
                        Exams
                    </span> untuk memulai ujian. Berdoa sebelum memulai
                </li>
                <li>
                    Kerjakan ujian satu subjek dalam satu waktu
                </li>
                <li>
                    <span class=" font-bold">Dilarang bekerja sama</span> dengan peserta lain
                </li>
            </ul>
        </x-card>

    </div>
@endsection
