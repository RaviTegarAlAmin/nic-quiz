<div>
    {{-- Teaching Card List --}}
    <div class=" md:flex md:justify-between md:gap-3 gap-5 w-full mx-auto px-0">
        <div
            class=" grid grid-flow-col grid-rows-2 gap-3 overflow-x-auto md:w-2/3 w-full py-4 border  border-secondary-400 px-4 rounded-md border-b-4 border-r-8 bg-gray-100/80 ">
            @foreach ($teachings as $teaching)
                <x-card @class([
                    ' w-64 cursor-pointer hover:shadow-xl border-2 border-l-4 border-gray-100 border-r-gray-200 hover:border-secondary-400 hover:rotate-1 transition-all ease-in-out',
                    'bg-secondary-400' =>
                        $currentTeaching != null && $currentTeaching->id == $teaching->id,
                ]) wire:key="teaching-{{ $teaching->id }}"
                    wire:click="changeCurrentTeaching({{ $teaching->id }})">
                    <div class=" flex justify-between mb-4">
                        <x-class-status-tag class=" !text-secondary-400">
                            {{ $teaching->classroom->name }}
                        </x-class-status-tag>
                        <x-tag>
                            {{ $teaching->course->name }}
                        </x-tag>
                    </div>
                    <p class=" font-semibold">
                        {{ 'Jadwal : ' }}
                    </p>
                    <p class=" font-semibold">
                        {{ 'Kode : ' }}
                    </p>
                </x-card>
            @endforeach
        </div>

        {{-- Classroom Info --}}
        <x-card class=" md:w-1/3 w-full border border-b-4 border-secondary-400 border-r-8">
            <h2 class=" font-bold text-secondary-400 mb-4">Info Pengajaran</h2>
            <hr class=" border border-secondary-300 w-full mx-auto">
            @if ($currentClassroom != null)
                <div class=" font-semibold" wire:loading.remove>
                    <div></div>
                    <p class=" m-2">Total Murid {{ $currentClassroom->students()->count() }}</p>
                    <p class=" m-2"> Total Ujian: {{ $examAssignments->count() }} </p>
                </div>
                <div class="flex items-center justify-center h-32" wire:loading>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
                        class="size-7 fill-primary motion-safe:animate-spin dark:fill-primary-dark">
                        <path d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"
                            opacity=".25" />
                        <path
                            d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z" />
                    </svg>
                </div>
            @else
                <div class=" py-14 text-center text-gray-400 text-lg">
                    Pilih pengajaran untuk melihat info
                </div>
            @endif

        </x-card>
    </div>

    {{-- Exam Taker Data Table For Teacher Grade --}}

    @if ($currentClassroom)
        <div class=" flex justify-between align-middle">
            <x-tag class="w-32 mt-5">Daftar Murid</x-tag>
        </div>
        <div class="md:overflow-x-visible overflow-x-auto">
            <div wire:loading
                class=" w-full min-h-28 bg-gray-100 animate-pulse border border-slate-100 drop-shadow-md rounded-md mt-5 flex justify-center items-center">
                <p class=" text-center font-bold text-secondary-400 opacity-50 align-middle">Memuat Tabel...</p>
            </div>
            <table
                class="table w-full border-separate border-spacing-0 drop-shadow-lg text-center rounded-lg overflow-hidden mt-10 border-r-8 border-r-secondary-500/60"
                wire:loading.remove>
                <thead class="bg-secondary-400 text-white px-4 py-6 font-semibold text-center">
                    <tr>
                        <th class="py-6">
                            Nama
                        </th>
                        <th>
                            NIS
                        </th>
                        <th>
                            Gender
                        </th>
                        <th>
                            TTL
                        </th>
                        <th>
                            Alamat
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($currentStudents as $student)
                        <tr class="odd:bg-white even:bg-slate-100 hover:bg-slate-200">

                            {{-- Generic Text Data --}}

                            <td class=" border px-4 py-2 whitespace-nowrap text-left flex justify-between">
                                <p  class=" hover:underline hover:text-secondary-400">
                                    {{ $student->name  }}
                                </p>

                            </td>
                            <td class=" border px-4 py-2 whitespace-nowrap">
                                {{ $student->nis }}
                            </td>
                            <td class=" border px-4 py-2 whitespace-nowrap">
                                {{ $student->gender == 'Laki-Laki' ? 'L' : 'P' }}
                            </td>
                            <td class=" border px-4 py-2 whitespace-nowrap">
                                {{ $student->born_date }}
                            </td>

                            <td class=" border px-4 py-2 whitespace-nowrap text-left">
                                {{ $student->address }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>
    @else
        {{-- No Current Classroom --}}
        <div
            class=" border-4 border-slate-100 border-dashed text-center text-slate-300 py-5 hover:border-slate-400/75 hover:text-slate-400/75 mt-8 cursor-pointer">
            Pilih Pengajaran
        </div>
    @endif
</div>
