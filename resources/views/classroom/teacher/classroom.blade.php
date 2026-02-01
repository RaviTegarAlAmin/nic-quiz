@extends('layout.main')

@section('main-content')

<livewire:classroom.teacher.classroom-index :teacher="$teacher"></livewire:classroom.teacher.classroom-index>

@endsection
