@extends('layout.main')

@section('main-content')

   <livewire:admin.teaching.index-teaching
   :courseIds="$courseIds"
   ></livewire:admin.teaching.index-teaching>

@endsection
