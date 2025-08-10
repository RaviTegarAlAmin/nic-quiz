@extends('layout.main')

@section('main-content')
    <x-header>Ubah Data Ujian</x-header>

    @livewire('exam.edit-exam', ['exam' => $exam])
@endsection
