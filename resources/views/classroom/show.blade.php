@extends('layout.main')

@section('main-content')
    <x-header>Data Kelas</x-header>

    <div class="flex justify-center items-center">
        <table class=" table-auto">
            <thead class=" table-header-group">
                <tr>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Tanggal Lahir</th>
                </tr>
            </thead>
            @foreach ($classroom->students as $student)
                <tr class="even:bg-slate-200">
                    <td class="py-2">{{ $student->name }}</td>
                    <td>{{ $student->gender }}</td>
                    <td>{{ $student->address }}</td>
                    <td>{{ $student->born_date }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
