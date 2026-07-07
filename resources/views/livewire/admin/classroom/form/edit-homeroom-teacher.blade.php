<div class="rounded-xl border border-secondary-200 bg-secondary-50/40 p-4">

    <label class="text-xs font-semibold uppercase tracking-wide text-gray-400">
        Pilih Wali Kelas
    </label>

    <select wire:model="selectedTeacherId" class="mt-2 w-full rounded-lg border border-gray-200 px-3 py-2 text-sm">
        <option value="">-- Pilih guru --</option>
        @foreach ($teachers as $teacher)
            <option value="{{ $teacher['id'] }}">
                {{ $teacher['name'] }}{{ $teacher['nip'] ? ' — NIP ' . $teacher['nip'] : '' }}
            </option>
        @endforeach
    </select>

    @error('selectedTeacherId')
        <p class="mt-1 text-xs text-danger-600">{{ $message }}</p>
    @enderror

    <div class="mt-4 flex justify-end gap-2">
        <x-button variant="outline" x-on:click="activeEdit=null" wire:loading.attr="disabled"
            class="!w-auto !rounded-lg !px-3 !py-1.5 !text-xs">
            Batal
        </x-button>

        <x-button variant="success" wire:click="save" wire:loading.attr="disabled"
            class="!w-auto !rounded-lg !px-3 !py-1.5 !text-xs">
            <span wire:loading.remove wire:target="save">Simpan</span>
            <span wire:loading wire:target="save">Menyimpan...</span>
        </x-button>

        <x-button
        x-show=""
        variant="danger" wire:click="deleteHomeroomTeacher" wire:loading.attr="disabled"
            class="!w-auto !rounded-lg !px-3 !py-1.5 !text-xs">
            <span wire:loading.remove wire:target="deleteHomeroomTeacher">Hapus</span>
            <span wire:loading wire:target="deleteHomeroomTeacher">Menyimpan...</span>
        </x-button>
    </div>

</div>
