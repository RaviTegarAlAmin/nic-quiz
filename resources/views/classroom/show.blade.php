@extends('layout.main')

@section('main-content')
    <x-header>Data Kelas</x-header>

    <div class="flex justify-center items-center">
        <table class=" table-auto overflow-auto mb-10">
            <thead>
                <tr class="border border-slate-300 rounded-tr-md rounded-rl-md bg-slate-200">
                    <th class="py-2 px-2">Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Tanggal Lahir</th>
                </tr>
            </thead>
            @foreach ($classroom->students as $student)
                <tr class="even:bg-slate-200 border-b-2 border-black">
                    <td class="py-2 px-3">{{ $student->name }}</td>
                    <td class="px-3">{{ $student->gender }}</td>
                    <td class="px-3">{{ $student->address }}</td>
                    <td class="px-3">{{ $student->born_date }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
