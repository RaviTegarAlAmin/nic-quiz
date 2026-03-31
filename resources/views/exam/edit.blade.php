@extends('layout.main')

@section('main-content')
    <x-header>Ubah Data Ujian</x-header>

    @livewire('exam.edit-exam', ['exam' => $exam])

    @include('teacher.exam.question-editor')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.11/dist/katex.min.css">
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.11/dist/katex.min.js"></script>



@endsection
