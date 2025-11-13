@extends('layout.main')

@section('main-content')
    <div class="p-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-secondary-400 to-secondary-300 rounded-lg shadow-lg px-6 py-4 mb-6">
            <h1 class="text-white text-2xl font-bold">DASHBOARD</h1>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Mapel Card -->
            <div class="bg-white rounded-lg shadow p-6 border-t-4 border-secondary-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Mapel</p>
                        <p class="text-3xl font-bold text-gray-800">5BK</p>
                    </div>
                    <div class="bg-secondary-400/10 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Jumlah Ujian Card -->
            <div class="bg-white rounded-lg shadow p-6 border-t-4 border-secondary-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Jumlah Ujian</p>
                        <p class="text-3xl font-bold text-gray-800">8 Ujian</p>
                    </div>
                    <div class="bg-secondary-300/10 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-secondary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Ujian Berlangsung -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-secondary-400 to-secondary-300 px-6 py-3">
                    <h2 class="text-white font-semibold">Ujian Berlangsung</h2>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Ujian 1 -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-gray-600 mt-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                </path>
                            </svg>
                            <div>
                                <h3 class="font-medium text-gray-800">Ujian Bab 1 Seni Budaya</h3>
                                <div class="flex gap-2 mt-2">
                                    <span class="bg-secondary-400 text-white text-xs px-2 py-1 rounded-full">8.3</span>
                                    <span class="bg-secondary-400 text-white text-xs px-2 py-1 rounded-full">8.2</span>
                                    <span class="bg-secondary-400 text-white text-xs px-2 py-1 rounded-full">8.4</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-gray-800">72</p>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                </svg>
                                <span>Peserta</span>
                            </div>
                        </div>
                    </div>

                    <!-- Ujian 2 -->
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-gray-600 mt-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                </path>
                            </svg>
                            <div>
                                <h3 class="font-medium text-gray-800">IPS</h3>
                                <div class="flex gap-2 mt-2">
                                    <span class="bg-secondary-400 text-white text-xs px-2 py-1 rounded-full">8.1</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-gray-800">46</p>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                </svg>
                                <span>Peserta</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nilai Rata-Rata Ujian -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-secondary-400 to-secondary-300 px-6 py-3">
                    <h2 class="text-white font-semibold">Nilai Rata-Rata Ujian</h2>
                </div>
                <div class="p-6">
                    <!-- Chart -->
                    <div class="mb-4">
                        <div class="flex items-end justify-between h-48 gap-4">
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-red-300 rounded-t-lg relative" style="height: 55%">
                                    <span
                                        class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-sm font-semibold text-gray-700">63</span>
                                </div>
                                <span class="mt-2 bg-secondary-400 text-white text-xs px-2 py-1 rounded-full">8.1</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-red-300 rounded-t-lg relative" style="height: 75%">
                                    <span
                                        class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-sm font-semibold text-gray-700">74</span>
                                </div>
                                <span class="mt-2 bg-secondary-400 text-white text-xs px-2 py-1 rounded-full">8.2</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-red-300 rounded-t-lg relative" style="height: 82%">
                                    <span
                                        class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-sm font-semibold text-gray-700">85</span>
                                </div>
                                <span class="mt-2 bg-secondary-400 text-white text-xs px-2 py-1 rounded-full">8.3</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-red-300 rounded-t-lg relative" style="height: 92%">
                                    <span
                                        class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-sm font-semibold text-gray-700">98</span>
                                </div>
                                <span class="mt-2 bg-secondary-400 text-white text-xs px-2 py-1 rounded-full">8.4</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-red-300 rounded-t-lg relative" style="height: 68%">
                                    <span
                                        class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-sm font-semibold text-gray-700">70</span>
                                </div>
                                <span class="mt-2 bg-secondary-400 text-white text-xs px-2 py-1 rounded-full">8.5</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Students -->
                    <div class="flex items-center justify-end mt-6 pt-4 border-t">
                        <svg class="w-8 h-8 text-gray-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                        </svg>
                        <span class="text-2xl font-bold text-gray-800">147 Murid</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification -->
        <div class="mt-6 bg-white rounded-lg shadow p-4 border-l-4 border-secondary-400">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-secondary-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-sm text-gray-600">Pemberitahuan</p>
                    <p class="font-medium text-gray-800">Ujian 2 IPA Kelas 8.1, 8.3, dan 8.5 dimulai dalam 10 jam</p>
                </div>
            </div>
        </div>
    </div>
@endsection
