@extends('layout.main')

@section('main-content')
    <x-header>Buat Ujian</x-header>
    <x-card>
        <div class=" grid grid-cols-3 gap-3">
            <div class="col-span-2 flex">
                <div><x-label for="title" class=" mr-3">Judul</x-label></div>
                <div class=" flex-1">
                    <x-form-input
                    type="text" name="title" id="title" placeholder="Tulis nama ujian..."/>
                </div>
            </div>
            <div class=" flex">
                <div><x-label for="title" class=" mr-3">Mata Pelajaran</x-label></div>
                <div class=" flex-1"><x-form-input
                    type="text" name="course_id" placeholder="Pilih Mata Pelajaran..."/>
                </div>
            </div>
            <div class="flex">
                <div><x-label for="title" class=" mr-3">Mulai</x-label></div>
                <div class=" flex-1"><x-form-input
                    type="datetime-local" name="start_at" placeholder="Waktu mulai..."/>
                </div>
            </div>
            <div class="flex">
                <div><x-label for="title" class=" mr-3">Akhir</x-label></div>
                <div class=" flex-1"><x-form-input
                    type="datetime-local"/>
                </div>
            </div>
            <div class="flex">
                <div><x-label for="title" class=" mr-3">Durasi</x-label></div>
                <div class=" flex-1"><x-form-input></x-text-input></div>
            </div>
        </div>
    </x-card>
@endsection
