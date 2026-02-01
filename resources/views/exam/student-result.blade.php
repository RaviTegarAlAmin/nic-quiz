@extends('layout.main')

@section('main-content')

    <x-header>

        <div class="flex flex-col gap-1">
            <h1 class="text-2xl font-bold leading-tight">
                Hasil {{ $assignment->exam->title }}
            </h1>
            <div class=" inline-block">
                <p class="text-sm text-black/70 mr-5">
                    {{ $student->name }}
                </p>

                <p class="text-sm text-black/70">
                    Kelas {{ $student->classroom->name }}
                </p>

            </div>

        </div>

    </x-header>


    {{-- Sudah Dinilai --}}
    @if ($examTaker->grade)
        <!-- Exam Result Summary -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <!-- Final Score -->
            <div
                class="bg-white rounded-xl shadow-lg border-t-4 border-secondary-400
               flex flex-col items-center justify-center p-6">

                <p class="text-sm text-gray-500 mb-1">
                    Nilai Akhir
                </p>

                <p @class([
                    'text-6xl font-extrabold leading-none',
                    'text-success-500' => $examTaker->grade->exam_score >= 75,
                    'text-danger-500' => $examTaker->grade->exam_score < 75,
                ])>
                    {{ $examTaker->grade->exam_score }}
                </p>

            </div>

            <!-- Exam Information -->
            <div class="bg-white rounded-xl shadow p-6 lg:col-span-2">

                <h3 class="font-semibold text-gray-800 mb-4">
                    Informasi Ujian
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-6 text-sm">

                    <div class="flex justify-between">
                        <span class="text-gray-500">Jumlah Soal PG</span>
                        <span class="font-semibold text-gray-800">
                            {{ $mcqQuestions }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Jumlah Soal Esai</span>
                        <span class="font-semibold text-gray-800">{{ $essayQuestions }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Jawaban PG Benar</span>
                        <span class="font-semibold text-success-600">16</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Nilai Esai</span>
                        <span class="font-semibold text-gray-800">
                            45 / 50
                        </span>
                    </div>

                </div>
            </div>

        </div>

        <!-- Question Answers List -->
        <div class="space-y-5">

            <!-- Question Card -->
            <x-card class="border-l-4 border-secondary-400 shadow-sm">

                <!-- Header -->
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-secondary-400 bg-secondary-400/10 px-3 py-1 rounded-full">
                            #1
                        </span>

                        <x-tag class="bg-secondary-400/10 text-secondary-400 border border-secondary-400/20">
                            Pilihan Ganda
                        </x-tag>
                    </div>

                    <span class="text-sm text-gray-500">
                        Skor: <span class="font-semibold text-gray-800">5 / 5</span>
                    </span>
                </div>

                <!-- Question -->
                <div class="mb-4">
                    <x-label>Pertanyaan</x-label>
                    <div class="bg-gray-50 border rounded-lg p-3 text-sm text-gray-700">
                        Apa ibu kota Indonesia?
                    </div>
                </div>

                <!-- Answer Options -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                    <div class="p-3 rounded-lg bg-success-50 border border-success-400 text-success-700">
                        Jakarta
                    </div>
                    <div class="p-3 rounded-lg bg-gray-50 border border-gray-200">
                        Bandung
                    </div>
                    <div class="p-3 rounded-lg bg-gray-50 border border-gray-200">
                        Surabaya
                    </div>
                    <div class="p-3 rounded-lg bg-gray-50 border border-gray-200">
                        Medan
                    </div>
                </div>

            </x-card>

            <!-- Essay Question Card -->
            <x-card class="border-l-4 border-secondary-400 shadow-sm">

                <!-- Header -->
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-secondary-400 bg-secondary-400/10 px-3 py-1 rounded-full">
                            #2
                        </span>

                        <x-tag class="bg-secondary-400/10 text-secondary-400 border border-secondary-400/20">
                            Esai
                        </x-tag>
                    </div>

                    <span class="text-sm text-gray-500">
                        Skor: <span class="font-semibold text-gray-800">8 / 10</span>
                    </span>
                </div>

                <!-- Question -->
                <div class="mb-4">
                    <x-label>Pertanyaan</x-label>
                    <div class="bg-gray-50 border rounded-lg p-3 text-sm text-gray-700">
                        Jelaskan pengertian globalisasi!
                    </div>
                </div>

                <!-- Student Answer -->
                <div class="mb-4">
                    <x-label>Jawaban Anda</x-label>
                    <div class="bg-gray-50 border rounded-lg p-3 text-sm text-gray-700">
                        Globalisasi adalah proses masuknya pengaruh dari luar ke dalam suatu negara.
                    </div>
                </div>

                <!-- Reference Answer -->
                <div class="mb-4">
                    <x-label>Jawaban Acuan</x-label>
                    <div class="bg-primary-50 border border-primary-300 rounded-lg p-3 text-sm text-gray-700">
                        Globalisasi adalah proses integrasi internasional yang terjadi akibat pertukaran
                        pandangan dunia, produk, dan aspek budaya lainnya.
                    </div>
                </div>

                <!-- Essay Score Info -->
                <div class="flex justify-end gap-3">
                    <x-tag class="bg-secondary-400 text-white">
                        Nilai: 8
                    </x-tag>
                    <x-tag class="border border-primary-600 bg-primary-500 text-white">
                        Kemiripan: 80%
                    </x-tag>
                </div>

            </x-card>

        </div>
    @else
        <div class="bg-danger-50 border-l-4 border-danger-500
           rounded-lg shadow-sm p-6 mb-8">

            <div class="flex items-start gap-4">

                <!-- Icon -->
                <div class="flex-shrink-0">
                    <div
                        class="w-12 h-12 rounded-full
                       bg-danger-500/10
                       flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-danger-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3m0 4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                        </svg>
                    </div>
                </div>

                <!-- Text -->
                <div class="flex-1">
                    <h2 class="text-lg font-bold text-danger-700 mb-1">
                        Hasil Ujian Belum Tersedia
                    </h2>

                    <p class="text-sm text-danger-700/90 leading-relaxed">
                        Jawaban ujian Anda telah berhasil dikumpulkan.
                        Saat ini hasil ujian masih dalam proses penilaian oleh sistem atau guru.
                        Silakan periksa kembali halaman ini di lain waktu.
                    </p>
                </div>

            </div>
        </div>
    @endif

@endsection
