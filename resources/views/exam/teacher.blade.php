@extends('layout.main')

@section('main-content')

    @if ($exams)
        <div class=" flex justify-between align-middle">
            <x-header>Daftar Ujian</x-header>
            <x-header>
                <a class=" text-5xl text-slate-400 hover:text-slate-500" href="{{ route('exams.create') }}"> + </a>
            </x-header>
        </div>

        <div class=" grid grid-cols-1 md:grid-cols-2 gap-3 container">
            @foreach ($exams as $exam)
                <x-card class="mb-4">
                    <div class=" flex justify-between mb-2">
                        <div>
                            <x-label class=" mb-4 hover:underline">
                                <a href="{{ route('exams.edit', ['exam' => $exam]) }}">
                                    {{ $exam->title }}
                                </a>
                            </x-label>
                            <p> {{ $exam->multiple_choice_count }} Soal Pilihan Ganda</p>
                            <p class="mb-4"> {{ $exam->essay_count }} Soal Esai</p>
                        </div>
                        <div>
                            <x-tag>{{ $exam->course->name }}</x-tag>
                        </div>
                    </div>

                    <div>

                        @if ($exam->examAssignments)
                            <x-label>Jumlah Penugasan</x-label>
                            <p class=" mb-2"> {{ $exam->examAssignments->count()}} Total Penugasan </p>
                        @else
                            <div class=" mb-2">
                                <p class=" text-danger-700">Belum Ada Kelas Aktif!</p>
                            </div>
                        @endif
                    </div>

                    <hr class=" border-1 border-slate-300 mb-2">
                    <div class=" flex justify-between">
                        <div>
                            <p class=" text-slate-400">
                                Dibuat Pada {{ date_format($exam->created_at, 'd-m-y ') }}
                            </p>
                        </div>
                        <div class=" flex gap-2">
                            <a href="{{ route('exams.edit', ['exam' => $exam]) }}"
                                class=" text-slate-300 hover:text-slate-400" title="Sunting Ujian">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-pencil-icon lucide-pencil">
                                    <path
                                        d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                    <path d="m15 5 4 4" />
                                </svg>
                            </a>
                            <a href="{{ route('exams.assignments.index', ['exam' => $exam->id]) }}"
                                class="text-slate-300 hover:text-slate-400" title="Atur Ujian">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings">
                                    <path
                                        d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </a>


                        </div>
                    </div>

                </x-card>
            @endforeach
        </div>
    @else
        <div class=" text-center text-slate-400 py-5">
            <p class="mb-5">Tidak ada pertanyaan</p>
            <hr class=" mx-auto w-3/4 h-0.5 bg-secondary-300-0.75">
        </div>
    @endif

@endsection
