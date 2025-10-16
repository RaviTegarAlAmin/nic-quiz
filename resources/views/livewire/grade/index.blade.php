@extends('layout.main')

@section('main-content')
    <x-header class=" mb-4 bg-secondary-400 text-white border-r-4 border-secondary-300 rounded-md">
        Penilaian {{ $exam->title }}
    </x-header>

    <div class=" md:flex md:justify-between md:gap-3">
        <div
            class=" grid grid-flow-col grid-rows-2 gap-3 overflow-x-auto md:w-2/3 w-full py-4 border  border-secondary-400 px-4 rounded-md border-b-4 border-r-8">
            @foreach ($examAssignments as $assignment)
                <x-card
                    class=" w-64 cursor-pointer hover:shadow-xl border-2 border-l-4 border-gray-100 border-r-gray-200 hover:border-secondary-400 hover:rotate-1 transition-all ease-in-out"
                    wire:key="assignment-{{ $assignment->id }}"
                    wire:click="changeCurrentAssignment({{ $assignment->id }})">
                    <div class=" flex justify-between mb-4">
                        <x-class-status-tag class=" !text-secondary-400">
                            {{ $assignment->examTakers->first()?->student?->classroom?->name }}
                        </x-class-status-tag>
                        <x-tag>
                            {{ $assignment->duration }}
                        </x-tag>
                        @dump($assignment->id)
                    </div>
                    <p>
                        {{ 'Mulai     :' . date_format($assignment->start_at, 'd M Y') }}
                    </p>
                    <p>
                        {{ 'Berakhir :' . date_format($assignment->end_at, 'd M Y') }}
                    </p>
                </x-card>
            @endforeach
        </div>
        <x-card class=" mr-10 md:w-1/3 w-full border border-b-4 border-secondary-400 border-r-8">
            <h2 class=" font-bold text-secondary-400 mb-4">Info Penugasan</h2>
            <hr class=" border border-secondary-300 w-full mx-auto">
            <p>
                @dump($currentAssignment->id ?? null)
            </p>
        </x-card>
    </div>
@endsection
