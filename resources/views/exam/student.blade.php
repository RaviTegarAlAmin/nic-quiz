@extends('layout.main')

@section('main-content')
    <x-header>Daftar Ujian</x-header>
    <div class=" grid grid-cols-1 lg:grid-cols-2 gap-2">
        @foreach ($assignments as $assignment)
            <x-card class=" mb-2">

                <div class=" flex justify-between">
                    <x-label>{{ Str::length($assignment->exam->title) > 50 ? substr($assignment->exam->title, 0, 50) . '...' : $assignment->exam->title }}</x-label>
                    <x-tag>{{ $assignment->teaching->course->name }}</x-tag>
                </div>


                <div class=" flex justify-between">
                    <p class=" font-semibold mt-2"> Berakhir Pada {{ date_format($assignment->end_at, 'd-m-y H:i') }}</p>
                    <p class=" font-semibold mt-2"> Pembuat: {{ $assignment->exam->teacher->name }}</p>
                </div>

                <hr class=" border border-slate-300 mt-3 mb-2">
                <div class=" flex justify-between align-middle">
                    <div>
                        @if ($assignment->status == 'not_started')
                            <p> Dimulai {{ $assignment->start_at->locale('id')->diffForHumans() }}</p>
                        @else
                            <x-class-status-tag :label="true" :status="$assignment->status" class=" hover:cursor-default"></x-class-status-tag>
                        @endif
                    </div>

                    <div>

                        @if ($assignment->status == 'ongoing')
                            @if ($assignment->examTakerForStudent?->isFinished())
                                <x-submit-button class=" rounded-lg hover:bg-success-700 bg-success-600" disabled>Disubmit</x-submit-button>
                            @else
                                <div x-data="{ modal: false }">
                                    <x-submit-button x-on:click="modal = !modal" class=" px-2 rounded-md">Mulai
                                        Ujian</x-submit-button>

                                    <form action="{{ route('student.exams.start', ['assignment' => $assignment]) }}"
                                        method="POST">
                                        @csrf
                                        <x-modal :message="'Konfirmasi Mulai Ujian?'">
                                            <x-submit-button type="submit">Mulai</x-submit-button>
                                        </x-modal>
                                    </form>
                                </div>
                            @endif
                        @elseif ($assignment->status == 'finished')
                            <x-link-button class="rounded-md px-3">
                                <span>
                                </span>
                                Lihat Hasil
                            </x-link-button>
                        @else
                            <x-submit-button class=" rounded-lg hover:bg-slate-300 bg-slate-300" disabled>Mulai
                                Ujian</x-submit-button>
                        @endif
                    </div>
                </div>
            </x-card>
        @endforeach
    </div>

    @if (session('success'))
        <div x-data="{
            toast: true,
            message: '{{ session('success') }}',
            type: 'success'
        }">
            <x-toast />
        </div>
    @endif
@endsection
