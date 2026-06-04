<div class=" grid grid-cols-2 gap-3 pr-3">

    <x-ui.detail-card
        class=" relative overflow-hidden col-span-2 pr-3 flex gap-2 border-gray-400/80 text-gray-600 md:text-left text-center !text-lg border-l-4 bg-warning-600/70 hover:shadow-sm font-bold">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-folder-kanban-icon lucide-folder-kanban text-gray-600/80">
            <path
                d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z" />
            <path d="M8 10v4" />
            <path d="M12 10v2" />
            <path d="M16 10v6" />
        </svg>
        Statistik Ujian
        <div class="absolute -right-20 -top-4 bg-white border-2 border-success-300 w-36 h-36 rounded-full opacity-30">
            &nbsp;
        </div>
    </x-ui.detail-card>

    {{-- Upcoming --}}

    <x-ui.detail-card
        class="relative border-gray-400/80 border-l-4 border-l-primary-600 hover:shadow-sm overflow-hidden">

        <div class=" flex justify-start gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-clipboard-clock-icon lucide-clipboard-clock text-primary-700">
                <path d="M16 14v2.2l1.6 1" />
                <path d="M16 4h2a2 2 0 0 1 2 2v.832" />
                <path d="M8 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h2" />
                <circle cx="16" cy="16" r="6" />
                <rect x="8" y="2" width="8" height="4" rx="1" />
            </svg>
            <div class=" -mt-2">
                <h6 class=" text-sm underline text-gray-600">
                    Ujian Mendatang
                </h6>
                <p class=" text-2xl">
                    {{ $upcoming ?? 0 }}
                </p>
            </div>
        </div>
        <div
            class="absolute -right-10 -top-4 bg-primary-600 border-2 border-primary-300 w-36 h-36 rounded-full opacity-30">
            &nbsp;
        </div>
    </x-ui.detail-card>

    {{-- Finished --}}

    <x-ui.detail-card
        class="relative border-gray-400/80 border-l-4 border-l-success-600 hover:shadow-sm overflow-hidden">

        <div class=" flex justify-start gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-circle-check-icon lucide-circle-check text-success-700">
                <circle cx="12" cy="12" r="10" />
                <path d="m9 12 2 2 4-4" />
            </svg>
            <div class=" -mt-2">
                <h6 class=" text-sm underline text-gray-600">
                    Ujian Selesai
                </h6>
                <p class=" text-2xl">
                    {{ $finished ?? 0 }}
                </p>
            </div>
        </div>
        <div
            class="absolute -right-10 -top-4 bg-success-400 border-2 border-success-300 w-36 h-36 rounded-full opacity-30">
            &nbsp;
        </div>
    </x-ui.detail-card>

    {{-- Latest Exam Activity --}}

</div>
