@extends('layout.main')

@section('main-content')
    <div class="p-6">

        <!-- Header -->
        <div class="bg-gradient-to-r from-secondary-400 to-secondary-300 rounded-lg shadow-lg px-6 py-4 mb-6">
            <h1 class="text-white text-2xl font-bold">DASHBOARD SISWA</h1>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            <!-- Total Exams -->
            <div class="bg-white rounded-lg shadow p-6 border-t-4 border-secondary-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Total Ujian</p>
                        <p class="text-3xl font-bold text-gray-800">6</p>
                    </div>
                    <div class="bg-secondary-400/10 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-secondary-400" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Completed Exams -->
            <div class="bg-white rounded-lg shadow p-6 border-t-4 border-secondary-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Ujian Selesai</p>
                        <p class="text-3xl font-bold text-gray-800">4</p>
                    </div>
                    <div class="bg-secondary-300/10 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-secondary-300" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Ongoing / Upcoming Exams -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-secondary-400 to-secondary-300 px-6 py-3">
                    <h2 class="text-white font-semibold">Ujian Berlangsung & Akan Datang</h2>
                </div>
                <div class="p-6 space-y-4">

                    <!-- Exam Item -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div>
                            <h3 class="font-medium text-gray-800">Matematika</h3>
                            <p class="text-sm text-gray-600">Mulai: 10:00 - 11:30</p>
                        </div>
                        <span class="bg-secondary-400 text-white text-xs px-3 py-1 rounded-full">
                            Aktif
                        </span>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div>
                            <h3 class="font-medium text-gray-800">Bahasa Indonesia</h3>
                            <p class="text-sm text-gray-600">Besok, 08:00</p>
                        </div>
                        <span class="bg-yellow-400 text-white text-xs px-3 py-1 rounded-full">
                            Akan Datang
                        </span>
                    </div>

                </div>
            </div>

            <!-- Recent Results -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-secondary-400 to-secondary-300 px-6 py-3">
                    <h2 class="text-white font-semibold">Hasil Ujian Terakhir</h2>
                </div>
                <div class="p-6 space-y-4">

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h3 class="font-medium text-gray-800">IPA</h3>
                            <p class="text-sm text-gray-600">Nilai</p>
                        </div>
                        <span class="text-2xl font-bold text-secondary-400">82</span>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <h3 class="font-medium text-gray-800">IPS</h3>
                            <p class="text-sm text-gray-600">Nilai</p>
                        </div>
                        <span class="text-2xl font-bold text-secondary-400">88</span>
                    </div>

                </div>
            </div>
        </div>

        <!-- Notification -->
        <div class="mt-6 bg-white rounded-lg shadow p-4 border-l-4 border-secondary-400">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-secondary-400 mr-3" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm text-gray-600">Pemberitahuan</p>
                    <p class="font-medium text-gray-800">
                        Ujian Matematika sedang berlangsung, silakan kerjakan sebelum waktu habis.
                    </p>
                </div>
            </div>
        </div>

    </div>
@endsection
