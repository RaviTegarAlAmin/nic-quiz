<form wire:submit="save" class="space-y-4">
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <x-label for="teacher-name">Nama Guru</x-label>
            <input id="teacher-name" type="text" wire:model="name"
                class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2">
            @error('name') <p class="mt-1 text-sm text-danger-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <x-label for="teacher-nip">NIP</x-label>
            <input id="teacher-nip" type="text" wire:model="nip"
                class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2">
            @error('nip') <p class="mt-1 text-sm text-danger-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <x-label for="teacher-gender">Gender</x-label>
            <select id="teacher-gender" wire:model="gender"
                class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2">
                <option value="">Pilih gender</option>
                <option value="Laki-Laki">Laki-Laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
            @error('gender') <p class="mt-1 text-sm text-danger-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <x-label for="teacher-born-date">Tanggal Lahir</x-label>
            <input id="teacher-born-date" type="date" wire:model="born_date"
                class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2">
            @error('born_date') <p class="mt-1 text-sm text-danger-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <x-label for="teacher-address">Alamat</x-label>
        <textarea id="teacher-address" wire:model="address" rows="4"
            class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2"></textarea>
        @error('address') <p class="mt-1 text-sm text-danger-600">{{ $message }}</p> @enderror
    </div>

    <div class="flex justify-end">
        <x-button type="submit" variant="success" class="w-full md:w-auto">Simpan Guru</x-button>
    </div>
</form>
