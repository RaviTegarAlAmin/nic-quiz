<form wire:submit="import" class="space-y-4">
    <div x-data="{ drag: false }" @dragover.prevent="drag = true" @dragleave.prevent="drag = false"
        @drop.prevent="drag = false; $refs.file.files = $event.dataTransfer.files; $refs.file.dispatchEvent(new Event('change'))"
        :class="drag ? 'border-secondary-400 bg-secondary-50' : 'border-slate-300 bg-slate-50'"
        class="w-full rounded-xl border-2 border-dashed p-8 text-center transition-all duration-200">

        <input type="file" accept=".xlsx,.xls" class="hidden" x-ref="file" wire:model="excelFile" id="excel-upload">

        <label for="excel-upload" class="cursor-pointer flex flex-col items-center gap-3">

            {{-- Excel Icon --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-emerald-500" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 16V4a1 1 0 011-1h7l5 5v8a1 1 0 01-1 1h-3M9 12l2 2 4-4" />

            </svg>

            <div class="text-sm font-medium text-slate-700">
                Upload File Excel
            </div>

            <div class="text-xs text-slate-500">
                Drag & drop file atau klik untuk memilih
            </div>

            <div class="text-xs text-slate-400">
                Format yang didukung: .xlsx, .xls
            </div>

            @if ($excelFile)
                <div class="text-xs font-medium text-secondary-500">
                    {{ $excelFile->getClientOriginalName() }}
                </div>
            @endif
        </label>
    </div>

    @error('excelFile')
        <p class="text-sm text-danger-600">{{ $message }}</p>
    @enderror

    <div class="flex justify-end">
        <x-button variant="success" wire:loading.attr="disabled" wire:target="excelFile,import">
            <span wire:loading.remove wire:target="import">Import</span>
            <span wire:loading wire:target="import">Mengunggah...</span>
        </x-button>
    </div>
</form>
