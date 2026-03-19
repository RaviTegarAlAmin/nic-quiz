<div class="space-y-4">
    <div class="rounded-lg border border-danger-200 bg-danger-50 px-4 py-4 text-sm text-danger-700">
        <p class="font-semibold">Konfirmasi penghapusan guru</p>
        <p class="mt-2">
            Anda akan menghapus <span class="font-semibold">{{ $teacher?->name ?? '-' }}</span> dengan NIP
            <span class="font-semibold">{{ $teacher?->nip ?? '-' }}</span>.
        </p>
    </div>

    <div class="flex justify-end">
        <x-button type="button" wire:click="delete" variant="danger" class="w-full md:w-auto">
            Hapus Guru
        </x-button>
    </div>
</div>
