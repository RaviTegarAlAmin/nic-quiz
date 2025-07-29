@extends('layout.main')

@section('main-content')
    <x-header>Edit Ujian</x-header>

    @livewire('exam.edit-exam', ['exam' => $exam])
@endsection
