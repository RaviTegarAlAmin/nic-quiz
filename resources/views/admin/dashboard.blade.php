@extends('layout.main')

@section('main-content')

<div class="p-6">

    <!-- Header -->
    <div class="bg-gradient-to-r from-secondary-400 to-secondary-300 rounded-lg shadow-lg px-6 py-4 mb-6">
        <h1 class="text-white text-2xl font-bold">Dashboard Admin</h1>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

        <!-- Classrooms -->
        <div class="bg-white rounded-lg shadow p-6 border-t-4 border-secondary-400">
            <p class="text-gray-500 text-sm mb-1">Total Kelas</p>
            <p class="text-3xl font-bold text-gray-800">12</p>
        </div>

        <!-- Courses -->
        <div class="bg-white rounded-lg shadow p-6 border-t-4 border-secondary-300">
            <p class="text-gray-500 text-sm mb-1">Total Mata Pelajaran</p>
            <p class="text-3xl font-bold text-gray-800">8</p>
        </div>

        <!-- Teachers -->
        <div class="bg-white rounded-lg shadow p-6 border-t-4 border-secondary-400">
            <p class="text-gray-500 text-sm mb-1">Total Guru</p>
            <p class="text-3xl font-bold text-gray-800">15</p>
        </div>

        <!-- Students -->
        <div class="bg-white rounded-lg shadow p-6 border-t-4 border-secondary-300">
            <p class="text-gray-500 text-sm mb-1">Total Siswa</p>
            <p class="text-3xl font-bold text-gray-800">320</p>
        </div>

    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Teaching Info -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-secondary-400 to-secondary-300 px-6 py-3">
                <h2 class="text-white font-semibold">Pengajaran</h2>
            </div>
            <div class="p-6">
                <p class="text-gray-500 text-sm">Total Relasi Pengajaran</p>
                <p class="text-3xl font-bold text-gray-800">25</p>
            </div>
        </div>

        <!-- System Info -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-secondary-400 to-secondary-300 px-6 py-3">
                <h2 class="text-white font-semibold">Informasi Sistem</h2>
            </div>
            <div class="p-6 text-sm text-gray-700 space-y-2">
                <p>Platform : <strong>NIC-Quiz</strong></p>
                <p>Role : <strong>Administrator</strong></p>
                <p>Status : <span class="text-green-600 font-semibold">Aktif</span></p>
            </div>
        </div>

    </div>

    <!-- Notification -->
    <div class="mt-6 bg-white rounded-lg shadow p-4 border-l-4 border-secondary-400">
        <p class="text-sm text-gray-600">Pemberitahuan</p>
        <p class="font-medium text-gray-800">
            Gunakan menu navigasi untuk mengelola data kelas, guru, siswa, dan mata pelajaran.
        </p>
    </div>

</div>
@endsection
