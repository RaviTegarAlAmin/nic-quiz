@extends('layout.main')

@section('main-content')

    @if ($exams)
        <!-- Header -->
        <div
            class="bg-gradient-to-r from-secondary-400 to-secondary-300
                    rounded-lg shadow-lg px-6 py-4 mb-6">
            <h1 class="text-white text-2xl font-bold">
                Daftar Ujian
            </h1>
        </div>

        <!-- Action Row -->

        <div x-data="{ form: false }">

            <!-- Action Button -->
            <div class="flex justify-end mb-6">
                <button type="button" x-on:click="form = !form"
                    class="inline-flex items-center gap-2
                   bg-secondary-400 text-white
                   px-4 py-2 rounded-lg
                   text-sm font-semibold
                   hover:bg-secondary-500 transition shadow focus:ring-2 focus:ring-offset-2 focus:ring-secondary-600 focus:ring-offset-white">
                    <span class="text-lg leading-none">+</span>
                    Tambah Ujian
                </button>
            </div>

            <!-- Toggle Form -->
            <div x-show="form" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-6" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-6">
                <livewire:exam.add-exam :courses="$courses" />
            </div>

        </div>



        <!-- Exams Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 container mt-10">
            @foreach ($exams as $exam)
                <x-card class="hover:shadow-lg transition">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <x-label class="mb-2 hover:underline block">
                                <a href="{{ route('teacher.exams.grade.index', ['exam' => $exam]) }}">
                                    {{ $exam->title }}
                                </a>
                            </x-label>
                            <p class="text-sm text-slate-600">
                                {{ $exam->multiple_choice_count }} Soal Pilihan Ganda
                            </p>
                            <p class="text-sm text-slate-600">
                                {{ $exam->essay_count }} Soal Esai
                            </p>
                        </div>

                        <x-tag>{{ $exam->course->name }}</x-tag>
                    </div>

                    <!-- Assignment Info -->
                    <div class="mb-4">
                        @if ($exam->examAssignments)
                            <x-label>Jumlah Penugasan</x-label>
                            <p class="text-sm text-slate-600">
                                {{ $exam->examAssignments->count() }} Total Penugasan
                            </p>
                        @else
                            <p class="text-sm text-danger-700">
                                Belum Ada Kelas Aktif!
                            </p>
                        @endif
                    </div>

                    <hr class="border-slate-200 mb-3">

                    <!-- Footer -->
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-slate-400">
                            Dibuat Pada {{ date_format($exam->created_at, 'd-m-y ') }}
                        </p>

                        <div class="flex gap-3">
                            <a href="{{ route('exams.edit', ['exam' => $exam]) }}"
                                class="text-slate-400 hover:text-secondary-400 transition" title="Sunting Ujian">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                    <path d="m15 5 4 4" />
                                </svg>
                            </a>

                            <a href="{{ route('exams.assignments.index', ['exam' => $exam->id]) }}"
                                class="text-slate-400 hover:text-secondary-400 transition" title="Atur Ujian">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0
                                                                           2.34 2.34 0 0 0 3.319 1.915
                                                                           2.34 2.34 0 0 1 2.33 4.033
                                                                           2.34 2.34 0 0 0 0 3.831
                                                                           2.34 2.34 0 0 1-2.33 4.033
                                                                           2.34 2.34 0 0 0-3.319 1.915
                                                                           2.34 2.34 0 0 1-4.659 0
                                                                           2.34 2.34 0 0 0-3.32-1.915
                                                                           2.34 2.34 0 0 1-2.33-4.033
                                                                           2.34 2.34 0 0 0 0-3.831
                                                                           2.34 2.34 0 0 1 2.33-4.033
                                                                           2.34 2.34 0 0 0 3.319-1.915" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </a>

                            <form action="{{ route('exams.destroy', ['exam' => $exam]) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="text-slate-400 hover:text-red-500 transition"
                                    title="Hapus Ujian">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                        <path d="M3 6h18" />
                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    </svg>

                                </button>
                            </form>
                        </div>
                    </div>

                </x-card>
            @endforeach
        </div>
    @else
        <div class="text-center text-slate-400 py-10">
            <p class="mb-4">Tidak ada pertanyaan</p>
            <hr class="mx-auto w-3/4 h-0.5 bg-secondary-300">
        </div>
    @endif

@endsection
