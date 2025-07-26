@extends('layout.main')

@section('main-content')
    <x-header>Buat Ujian</x-header>
    @livewire('exam.add-exam', ['teachings' => $teachings, 'courses' => $courses])

@endsection
