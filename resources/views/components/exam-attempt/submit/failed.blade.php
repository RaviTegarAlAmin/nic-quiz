<div class="space-y-6">
    <div class="py-6 text-center">
        <h2 class="mb-5 text-xl font-bold text-danger-600">Submit Ujian Gagal</h2>

        <div class="mb-6 flex justify-center">
            <div class="rounded-full bg-danger-100 p-4 text-danger-600 motion-safe:animate-pulse">
                <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-circle-x-icon lucide-circle-x">
                    <circle cx="12" cy="12" r="10" />
                    <path d="m15 9-6 6" />
                    <path d="m9 9 6 6" />
                </svg>
            </div>
        </div>

        <p class="text-sm text-slate-500">
            Terjadi kendala saat mengirim ujian. Silakan coba lagi.
        </p>
    </div>

    <div class="flex justify-center gap-3">
        <x-button @click.prevent="submit('{{ route('student.exams.index') }}')" class="w-48" variant="danger">
            Coba Lagi
        </x-button>

        <x-button @click="submit_form = false" class="w-40" variant="secondary">
            Tutup
        </x-button>
    </div>
</div>
