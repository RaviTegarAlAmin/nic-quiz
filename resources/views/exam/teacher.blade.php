@extends('layout.main')

@section('main-content')

    @foreach ( $exams as $exam)
        <x-card class="mb-4">
         <div>{{ $exam->title }}</div>
         <div>{{ $exam->course->name }}</div>
        </x-card>
    @endforeach
@endsection
