<div class="rounded-xl border border-secondary-200 bg-secondary-50/40 p-4">

    <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
        <x-form wire:model="name" name="name" label="Nama Kelas" placeholder="Contoh: 9A" />

        <select wire:model.blur="grade" id="grade"
            name="grade"
            class="w-full border border-secondary-100 focus:border-secondary-400 focus:ring-1 focus:ring-primary-400 shadow-sm hover:shadow-md rounded-sm text-sm font-normal py-1 px-2 focus:outline-none">
            <option value="">Pilih Tingkat...</option>
            @for ($i = 7; $i <= 9; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>

        <x-form wire:model="capacity" name="capacity" type="number" label="Kapasitas" placeholder="Contoh: 32" />
    </div>

    <div class="mt-4 flex justify-end gap-2">
        <x-button variant="outline" x-on:click="activeEdit = null" wire:loading.attr="disabled"
            class="!w-auto !rounded-lg !px-3 !py-1.5 !text-xs">
            Batal
        </x-button>

        <x-button variant="success" wire:click="save" wire:loading.attr="disabled"
            class="!w-auto !rounded-lg !px-3 !py-1.5 !text-xs">
            <span wire:loading.remove wire:target="save">Simpan</span>
            <span wire:loading wire:target="save">Menyimpan...</span>
        </x-button>
    </div>

</div>
