@extends('layout.main')

@section('main-content')
    <x-header>
        Penugasan Ujian
    </x-header>

    @livewire('exam-assignment.assign-classes', ['exam' => $exam])

@endsection
