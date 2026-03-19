<div>

    <x-header>
        Data Siswa
    </x-header>


    {{-- Classroom Card List --}}
    <div class=" md:flex md:justify-between md:gap-3 gap-5 w-full mx-auto px-0">

        <div class=" grid grid-flow-col grid-rows-2 gap-3 overflow-x-auto md:w-2/3 w-full py-4 border  border-secondary-400 px-4 rounded-md border-b-4 border-r-8 bg-gray-100/80 "
            wire:loading.class="pointer-events-none select-none cursor-progress" wire:target="changeCurrentClassroom">

            @foreach ($classrooms as $classroom)
                <x-card @class([
                    ' w-64 cursor-pointer hover:shadow-xl border-2 border-l-4 border-gray-100 border-r-gray-200 hover:border-secondary-400 hover:rotate-1 transition-all ease-in-out',
                    'border-r-secondary-400 border-secondary-400 shadow-md select-none pointer-events-none' =>
                        $currentClassroomId == $classroom['id'],
                ]) wire:key="classroom-{{ $classroom['id'] }}"
                    wire:click="changeCurrentClassroom({{ $classroom['id'] }})">

                    <div class=" flex justify-between mb-4">
                        <x-class-status-tag class=" !text-secondary-400">
                            {{ $classroom['name'] ?? 'Tidak ada kelas' }}
                        </x-class-status-tag>

                        <x-tag class=" font-normal">
                            {{ $classroom['total_student'] . ' Siswa' }}
                        </x-tag>

                    </div>
                </x-card>
            @endforeach

        </div>

        {{-- classroom Info --}}
        <x-card class=" md:w-1/3 w-full border border-b-4 border-secondary-400 border-r-8">
            <h2 class=" font-bold text-secondary-400 mb-4">Data Kelas {{ $currentClassroom->name ?? '' }}</h2>
            <hr class=" border border-secondary-300 w-full mx-auto">

            @if ($currentClassroom != null)
                <div class=" font-semibold" wire:loading.remove wire:target="changeCurrentClassroom">

                    <p class=" m-2"> Total Murid {{ $currentStudents->count() }} </p>
                    <p class=" m-2">Laki-Laki {{ $currentClassroom['male_student'] }}</p>
                    <p class=" m-2">Perempuan {{ $currentClassroom['female_student'] }}</p>

                </div>


                {{-- Spinner --}}
                <div class=" h-32 relative w-full -mx-4 -my-4" wire:loading wire:target="changeCurrentClassroom">
                    <div class="absolute left-1/2 top-1/2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"
                            class="size-10 fill-secondary-400 motion-safe:animate-spin dark:fill-primary-dark">
                            <path d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"
                                opacity=".25" />
                            <path
                                d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z" />
                        </svg>
                    </div>

                </div>
            @else
                <div class=" py-14 text-center text-gray-400 text-lg">
                    Pilih Ruang Kelas
                </div>
            @endif

        </x-card>
    </div>

    {{-- Students Table --}}


    {{-- Students Data Per Classroom --}}

    @if ($currentClassroom)
        {{-- Table Name --}}
        <div class=" flex justify-between align-middle">
            <div>
                <x-tag class="mt-5">Tabel Siswa Kelas {{ $currentClassroom['name'] }}</x-tag>
            </div>
            <div x-data="{
                modalform: $wire.entangle('modalform'),
            }" class="mt-5">

                <div class="inline-flex rounded-lg shadow overflow-hidden border border-slate-300">

                    {{-- Add Student --}}
                    <button type="button" x-on:click="modalform = true"
                        class="inline-flex items-center gap-2
                   bg-secondary-400 text-white
                   px-4 py-2 text-sm font-semibold
                   hover:bg-secondary-500 transition
                   focus:outline-none focus:ring-2 focus:ring-secondary-600">
                        <span class="text-lg leading-none">+</span>
                        Tambah Siswa
                    </button>

                    {{-- Upload Excel --}}
                    <button type="button" wire:click="openUploadModal"
                        class="inline-flex items-center gap-2
                   bg-success-600 text-white
                   px-4 py-2 text-sm font-semibold
                   hover:bg-success-700 transition
                   border-l border-success-600
                   focus:outline-none focus:ring-2 focus:ring-success-700">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-file-up-icon lucide-file-up">
                                <path
                                    d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                <path d="M12 12v6" />
                                <path d="m15 15-3-3-3 3" />
                            </svg>
                        </span>
                        Upload
                    </button>

                    {{-- Download File --}}
                    <a href="{{ route('admin.download.classroom.students', ['classroomId' => $currentClassroom['id']]) }}"
                        class="inline-flex items-center gap-2
                   bg-primary-700 text-white
                   px-4 py-2 text-sm font-semibold
                   hover:bg-primary-800 transition
                   border-l border-slate-300
                   focus:outline-none focus:ring-2 focus:ring-primary-800">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-file-down-icon lucide-file-down">
                                <path
                                    d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                <path d="M12 18v-6" />
                                <path d="m9 15 3 3 3-3" />
                            </svg>
                        </span>
                        Download
                    </a>

                </div>


                {{-- Add Student Modal --}}
                <div x-show="modalform" x-cloak>
                    <x-modal-form formName="Tambahkan Siswa">
                        @livewire('admin.student.add-student', ['classroomId' => $currentClassroomId], 'add-student-' . $currentClassroomId)
                    </x-modal-form>
                </div>

                {{-- Upload Excel Modal --}}
                <div x-data="{ modalform: $wire.entangle('modalUpload') }" x-cloak>

                    <x-modal-form formName="Upload Data Siswa">

                        <livewire:admin.student.upload />

                    </x-modal-form>
                </div>
                {{-- Edit Student Modal --}}


                @if ($formStudentId)
                    <div x-data="{ modalform: $wire.entangle('modalEdit') }" x-cloak>

                        <x-modal-form formName="Sunting Data Siswa">

                            <livewire:admin.student.edit-student :student-id="$formStudentId" :key="'edit-student-' . $formStudentId" />

                        </x-modal-form>
                    </div>
                @endif



                {{-- Delete Modal --}}
                <div x-data="{ modal: $wire.entangle('modalDelete') }">
                    <x-modal
                        message="Hapus {{ $selectedStudent->name ?? '' }} Dari {{ $currentClassroom['name'] ?? '' }}">

                        <x-button wire:click="deleteStudent" variant="danger" class=" w-full">
                            Hapus
                        </x-button>
                    </x-modal>

                </div>

            </div>


        </div>


        {{-- Data Table for Current Classroom Students --}}

        <livewire:admin.student.index-student-data-table :classroom-id="$currentClassroomId" :key="'student-table-' . $currentClassroomId" />
    @else
        {{-- No Current Assignment --}}
        <div
            class=" border-4 border-slate-100 border-dashed text-center text-slate-300 py-5 hover:border-slate-400/75 hover:text-slate-400/75 mt-8 cursor-pointer">
            Pilih Kelas
        </div>
    @endif

    <div x-data="{
        toast: false,
        message: '',
        type: 'success'
    }"
        x-on:show-toast.window="
        toast = true;
        message = $event.detail[0].message || '';
        type = $event.detail[0].type || 'success';
     ">

        <x-toast />

    </div>
</div>
