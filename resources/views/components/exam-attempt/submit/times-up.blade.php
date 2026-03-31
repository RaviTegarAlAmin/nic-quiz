<div class="mb-4 text-center">
    <h2 class="mb-5 text-xl font-bold text-slate-800">Waktu Habis</h2>

    <div class="mb-6 flex justify-center">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-clock-alert-icon lucide-clock-alert text-danger-500 motion-safe:animate-pulse">
                <path d="M12 6v6l4 2" />
                <path d="M20 12v5" />
                <path d="M20 21h.01" />
                <path d="M21.25 8.2A10 10 0 1 0 16 21.16" />
            </svg>
        </div>
    </div>

    <p class="mt-2 text-sm text-slate-500">
        Waktu pengerjaan ujian telah berakhir. Silakan selesaikan pengumpulan ujian.
    </p>
</div>

<hr class="mb-5 h-1 rounded-sm border-0 bg-gray-300">

<div class="flex justify-center w-full">
    <x-button @click.prevent="submit('{{ route('student.exams.index') }}')" class="w-64" variant="success">
        Selesaikan Ujian
    </x-button>
</div>
