<div class="rounded-xl border border-danger-200 bg-danger-50/40 p-4">

    <div class="flex items-start gap-3">
        <div
            class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg border border-danger-200 bg-danger-50 text-danger-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                <line x1="12" x2="12" y1="9" y2="13" />
                <line x1="12" x2="12.01" y1="17" y2="17" />
            </svg>
        </div>

        <div class="min-w-0">
            <p class="text-sm font-semibold text-gray-800">
                Hapus Kelas {{ $classroomName }}
            </p>

            <p class="mt-1 text-sm text-gray-600">
                @if ($totalStudents > 0)
                    Kelas ini memiliki <span class="font-semibold text-danger-700">{{ $totalStudents }} murid</span>.
                    Menghapus kelas tidak akan menghapus data murid, namun murid akan kehilangan penempatan kelasnya.
                @else
                    Kelas ini belum memiliki murid. Tindakan ini tetap tidak dapat dibatalkan.
                @endif
            </p>
        </div>
    </div>

    <div class="mt-4">
        <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">
            Ketik <span class="font-mono text-danger-700">{{ $this->expectedPhrase }}</span> untuk konfirmasi
        </label>

        <input type="text" wire:model="confirmationInput" autocomplete="off"
            placeholder="{{ $this->expectedPhrase }}"
            class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:border-danger-400 focus:outline-none focus:ring-1 focus:ring-danger-400">

        @error('confirmationInput')
            <p class="mt-1 text-xs text-danger-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="mt-4 flex justify-end gap-2">
        <x-button variant="secondary" @click="activeEdit = null" wire:loading.attr="disabled"
            class="!w-auto !rounded-lg !px-3 !py-1.5 !text-xs">
            Batal
        </x-button>

        <x-button variant="danger" wire:click="delete" wire:loading.attr="disabled" wire:target="delete"
            class="!w-auto !rounded-lg !px-3 !py-1.5 !text-xs">
            <span wire:loading.remove wire:target="delete">Hapus Kelas</span>
            <span wire:loading wire:target="delete">Menghapus...</span>
        </x-button>
    </div>

</div>
