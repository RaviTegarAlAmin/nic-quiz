<div class=" overflow-x-auto">
    <table
        class="table-fixed w-full border-separate border-spacing-0 drop-shadow-lg
           text-center rounded-lg overflow-hidden
           border-r-8 border-r-secondary-500/60
           transition-all duration-200
           pointer-events-auto mt-10">

        <thead class="bg-secondary-400 text-white px-4 py-6 font-semibold text-center">
            <tr>
                <th class="w-56 py-6 text-center px-4">Nama</th>
                <th class="w-20">Gender</th>
                <th class="w-32">NIS</th>
                <th class="w-auto px-4 text-center">Alamat</th>
                <th class="w-28">Aksi</th>
            </tr>
        </thead>

        <tbody
            wire:loading.class="grayscale blur-sm brightness-90 contrast-75 pointer-events-none select-none transition-all duration-200">

            @foreach ($currentStudents as $student)
                <tr class="odd:bg-white even:bg-slate-100 hover:bg-slate-200">

                    {{-- Nama --}}
                    <td class="border px-4 py-2 whitespace-nowrap text-left">
                        <a href="" class="hover:underline hover:text-seondary-400">
                            {{ $student->name }}
                        </a>
                    </td>

                    {{-- Gender --}}
                    <td class="border px-4 py-2 whitespace-nowrap">
                        {{ $student->gender == 'Laki-Laki' ? 'L' : 'P' }}
                    </td>

                    {{-- NIS --}}
                    <td class="border px-4 py-2 whitespace-nowrap">
                        {{ $student->nis }}
                    </td>

                    {{-- Alamat --}}
                    <td class="border px-4 py-2 text-left">
                        <div class="truncate max-w-full" title="{{ $student->address }}">
                            {{ $student->address }}
                        </div>
                    </td>

                    {{-- Aksi --}}
                    <td
                        class="border px-4 py-2 whitespace-nowrap
                           flex gap-3 text-center justify-center">


                        <button class="text-slate-400 hover:text-secondary-400 transition" title="Sunting Ujian"
                            wire:click="$parent.openEditModal({{ $student->id }})" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                <path d="m15 5 4 4" />
                            </svg>
                        </button>


                        <button wire:click="$parent.openDeleteModal({{ $student->id }})" type="submit"
                            class="text-slate-400 hover:text-red-500 transition" title="Hapus Ujian">

                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                <path d="M3 6h18" />
                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                            </svg>
                        </button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
