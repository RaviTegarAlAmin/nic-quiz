<div class="mb-4 text-center">
    <h2 class="mb-5 text-xl font-bold text-slate-800">Selesaikan Ujian</h2>

    <div class="mb-6 flex justify-center">
        <div class="rounded-full bg-secondary-100 p-4 text-secondary-500 motion-safe:animate-pulse">
            <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-file-check-2">
                <path d="M16 22h2a2 2 0 0 0 2-2V7.5L14.5 2H6a2 2 0 0 0-2 2v3" />
                <path d="M14 2v6h6" />
                <path d="m3 15 2 2 4-4" />
            </svg>
        </div>
    </div>

    <p class="mt-2 text-sm text-slate-500">
        Pastikan semua jawaban sudah benar sebelum mengirim ujian.
    </p>
</div>

<hr class="mb-5 h-1 rounded-sm border-0 bg-gray-300">

<div class="flex justify-center gap-3">
    <x-button @click.prevent="submit('{{ route('student.exams.index') }}')" class="w-56" variant="success">
        Selesaikan Ujian
    </x-button>

    <x-button @click="submit_form = false" class="w-40" variant="secondary">
        Batal
    </x-button>
</div>
