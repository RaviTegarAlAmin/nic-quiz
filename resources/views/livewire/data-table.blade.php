{{--  This Data Tablse specficicay created for Exam Asssignment  --}}
<div class="md:overflow-x-visible overflow-x-auto">
    <table class="table w-full border-separate border-spacing-0 drop-shadow-lg text-center rounded-lg overflow-hidden">
        <thead class="bg-gray-100">
            <tr>
                @foreach ($columns as $column)
                    <th class="border px-4 py-2 font-semibold text-gray-700 text-center">
                        {{ $column['label'] }}
                    </th>
                @endforeach
                <th class="border px-4 py-2 font-semibold text-gray-700 text-center">
                    Status
                </th>
                <th class="border px-4 py-2 font-semibold text-gray-700 text-center">
                    Published
                </th>
                <th class="border px-4 py-2 font-semibold text-gray-700 text-center">
                    Aksi
                </th>
                <th class="border px-4 py-2 font-semibold text-gray-700 text-center">
                    Ubah Status
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($model as $data)
                <tr class="odd:bg-white even:bg-slate-100 hover:bg-slate-200">

                    {{-- Generic Text Data --}}

                    <td class=" border px-4 py-2 whitespace-nowrap">
                        {{ $data->start_at->format('D, d M Y H:i') }}
                    </td>
                    <td class=" border px-4 py-2 whitespace-nowrap">
                        {{ date_format($data->end_at, 'D, d M Y H:i') }}
                    </td>
                    <td class=" border px-4 py-2 whitespace-nowrap">
                        {{ $data->duration }}
                    </td>

                    <td class=" border px-4 py-2 whitespace-nowrap">
                        {{ $data->teaching->classroom->name }}
                    </td>

                    {{-- Specific Model Data and Non-Text Data --}}
                    <td class=" border px-4 py-2 whitespace-nowrap">
                        <x-class-status-tag :label="true" :status="$data->status"></x-class-status-tag>
                    </td>
                    <td class=" border px-4 py-2 whitespace-nowrap">
                        @if ($data->published)
                            <x-class-status-tag :label="true" :status="'published'"></x-class-status-tag>
                        @else
                            <x-class-status-tag>Belum</x-class-status-tag>
                        @endif
                    </td>
                    @if ($action)
                        <td class="border px-4 py-2">
                            <div class="flex flex-auto justify-center gap-3">
                                <div wire:click="publishExam({{ $data }})">
                                    <span title="Sebarkan Ujian"
                                        class="text-slate-400 cursor-pointer hover:text-secondary-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-message-square-share-icon lucide-message-square-share">
                                            <path
                                                d="M12 3H4a2 2 0 0 0-2 2v16.286a.71.71 0 0 0 1.212.502l2.202-2.202A2 2 0 0 1 6.828 19H20a2 2 0 0 0 2-2v-4" />
                                            <path d="M16 3h6v6" />
                                            <path d="m16 9 6-6" />
                                        </svg>
                                    </span>
                                </div>
                                <div wire:click="delete({{ $data }})">
                                    <span title="Hapus Pertanyaan"
                                        class="text-slate-400 cursor-pointer hover:text-danger-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-trash2-icon lucide-trash-2">
                                            <path d="M10 11v6" />
                                            <path d="M14 11v6" />
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                            <path d="M3 6h18" />
                                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        </svg>
                                    </span>
                                </div>

                            </div>

                        </td>
                    @endif

                    <td class="border px-4 py-2">
                        <div class=" flex flex-auto justify-around ">
                            @if ($data->status == 'ongoing')
                                <div>
                                    <span title="Pause Ujian"
                                        class=" text-warning-400 cursor-pointer hover:text-warning-300"
                                        wire:click="changeStatus({{$data->id}}, 'on_hold')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-pause-icon lucide-pause">
                                            <rect x="14" y="3" width="5" height="18" rx="1" />
                                            <rect x="5" y="3" width="5" height="18" rx="1" />
                                        </svg>

                                    </span>
                                </div>
                            @else
                                <div>
                                    <span title="Jalankan Ujian"
                                        class=" text-secondary-400 cursor-pointer hover:text-secondary-500"
                                        wire:click="changeStatus({{$data->id}}, 'ongoing')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-play-icon lucide-play">
                                            <path
                                                d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z" />
                                        </svg>
                                    </span>
                                </div>
                            @endif

                            <div>
                                <span title="Berhentikan Ujian"
                                    class="text-danger-700 cursor-pointer hover:text-danger-800"
                                    wire:click="changeStatus({{$data->id}}, 'finished')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-circle-stop-icon lucide-circle-stop">
                                        <circle cx="12" cy="12" r="10" />
                                        <rect x="9" y="9" width="6" height="6" rx="1" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

</div>
