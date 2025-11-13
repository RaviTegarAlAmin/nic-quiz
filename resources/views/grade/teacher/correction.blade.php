@extends('layout.main')

@section('main-content')

    <livewire:grade.teacher.correction
    :exam="$exam"
    :examTakers="$examTakers"
    :examTakerId="$examTakerId" >
    </livewire:grade.teacher.correction>


@endsection
