@extends('layout.main')

@section('main-content')



    @if ($classrooms)
        <!-- Header -->
        <div
            class="bg-gradient-to-r from-secondary-400 to-secondary-300
                    rounded-lg shadow-lg px-6 py-4 mb-6">
            <h1 class="text-white text-2xl font-bold">
                Daftar Kelas
            </h1>
        </div>

        <!-- Action Row -->

        <div x-data="{ form: false }">

            <!-- Action Button -->
            <div class="flex justify-end mb-6">
                <button type="button" x-on:click="form = !form"
                    class="inline-flex items-center gap-2
                   bg-secondary-400 text-white
                   px-4 py-2 rounded-lg
                   text-sm font-semibold
                   hover:bg-secondary-500 transition shadow focus:ring-2 focus:ring-offset-2 focus:ring-secondary-600 focus:ring-offset-white">
                    <span class="text-lg leading-none">+</span>
                    Tambah Kelas
                </button>
            </div>

            <div x-show="form" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-6" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-6">
                <livewire:admin.classroom.add-classroom />
            </div>


        </div>



        <!-- Classrooms Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 container mt-10">
            @foreach ($classrooms as $classroom)
                <x-card class="hover:shadow-lg transition">

                    <!-- Title & Grade -->
                    <div class="flex justify-between items-start mb-4">
                            <x-tag class="mb-2 hover:underline block">
                                {{ $classroom->name }}
                            </x-tag>
                            <x-label class="text-sm text-slate-600">
                                 Kapasitas: {{ $classroom->capacity }} Siswa
                            </x-label>
                    </div>

                    <div>
                        <p>
                            {{ $classroom->female_students }} Perempuan
                        </p>
                        <p>
                            {{ $classroom->male_students }} Laki-Laki
                        </p>
                    </div>



                    <hr class="border-slate-200 mb-3">

                    <!-- Footer -->
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-slate-400">
                            Diperbaharui Pada {{ date_format($classroom->updated_at, 'd-m-y ') }}
                        </p>

                        <div x-data="{ modal: false, modalform : false }" class="flex gap-3">
                            <p   x-on:click="modalform = !modalform"
                                class="text-slate-400 hover:text-secondary-400 transition" title="Sunting Kelas">
                                <svg

                                    xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                    <path d="m15 5 4 4" />
                                </svg>
                            </p>

                            <div x-show="modalform" x-cloak>
                                <x-modal-form formTarget="admin.classroom.edit">
                                    Ubah Data Kelas
                                </x-modal-form>
                            </div>

                            <button type="submit" class="text-slate-400 hover:text-red-500 transition" title="Hapus Kelas"
                                x-on:click="modal = !modal">

                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                    <path d="M3 6h18" />
                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                </svg>

                            </button>

                            <x-modal message="Hapus Kelas?">

                                <form action="{{ route('admin.classrooms.destroy', ['classroom' => $classroom]) }}"
                                    method="POST" class=" w-full">
                                    @csrf
                                    @method('DELETE')

                                    <x-submit-button class=" bg-danger-600/80 w-full border-2 border-transparent hover:border-danger-800 hover:bg-danger-700/80"
                                        x-on:click="modal=!modal">Ya</x-submit-button>

                                </form>

                            </x-modal>


                        </div>
                    </div>

                </x-card>
            @endforeach
        </div>
    @else
        <div class="text-center text-slate-400 py-10">
            <p class="mb-4">Tidak ada kelas</p>
            <hr class="mx-auto w-3/4 h-0.5 bg-secondary-300">
        </div>
    @endif

    <div x-data="{
        toast: false,
        message: '',
        type: 'success'
    }" x-init="@if (session('success')) toast = true;
            message = '{{ session('success') }}';
            type = 'success';
        @elseif (session('error'))
            toast = true;
            message = '{{ session('error') }}';
            type = 'error'; @endif"
        x-on:show-toast.window="
        toast = true;
        message = $event.detail[0].message || '';
        type = $event.detail[0].type || 'success';
    ">
        <x-toast />
    </div>


@endsection
