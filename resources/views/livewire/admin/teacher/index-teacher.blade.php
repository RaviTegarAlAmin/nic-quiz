<div>
    <x-header>
        Data Guru
    </x-header>

    <div class="grid gap-4 md:grid-cols-3">
        <x-card class="border border-b-4 border-secondary-400 border-r-8">
            <p class="text-sm font-semibold text-slate-500">Total Guru</p>
            <p class="mt-3 text-3xl font-bold text-secondary-400">{{ $stats['total'] }}</p>
        </x-card>
        <x-card class="border border-b-4 border-secondary-400 border-r-8">
            <p class="text-sm font-semibold text-slate-500">Guru Laki-Laki</p>
            <p class="mt-3 text-3xl font-bold text-secondary-400">{{ $stats['male'] }}</p>
        </x-card>
        <x-card class="border border-b-4 border-secondary-400 border-r-8">
            <p class="text-sm font-semibold text-slate-500">Guru Perempuan</p>
            <p class="mt-3 text-3xl font-bold text-secondary-400">{{ $stats['female'] }}</p>
        </x-card>
    </div>

    <x-card class="mt-6 border border-b-4 border-secondary-400 border-r-8 bg-white/95">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <x-tag class="mb-2">Direktori Guru</x-tag>
                <p class="text-sm text-slate-500">Kelola profil guru dengan modal untuk tambah, edit, dan hapus data.</p>
            </div>
            <button type="button" wire:click="openAddModal"
                class="inline-flex items-center gap-2 rounded-lg bg-secondary-400 px-4 py-2 text-sm font-semibold text-white transition hover:bg-secondary-500">
                <span class="text-lg leading-none">+</span>
                Tambah Guru
            </button>
        </div>
    </x-card>

    <div class="mt-6">
        <livewire:admin.teacher.index-teacher-data-table />
    </div>

    <div x-data="{ modalform: $wire.entangle('modalAdd') }" x-cloak>
        <x-modal-form formName="Tambahkan Guru">
            <livewire:admin.teacher.add-teacher />
        </x-modal-form>
    </div>

    @if ($selectedTeacherId)
        <div x-data="{ modalform: $wire.entangle('modalEdit') }" x-cloak>
            <x-modal-form formName="Sunting Data Guru">
                <livewire:admin.teacher.edit-teacher :teacher-id="$selectedTeacherId" :key="'edit-teacher-' . $selectedTeacherId" />
            </x-modal-form>
        </div>

        <div x-data="{ modalform: $wire.entangle('modalDelete') }" x-cloak>
            <x-modal-form formName="Hapus Guru">
                <livewire:admin.teacher.delete-teacher :teacher-id="$selectedTeacherId" :key="'delete-teacher-' . $selectedTeacherId" />
            </x-modal-form>
        </div>
    @endif

    <div x-data="{ toast: false, message: '', type: 'success' }"
        x-on:show-toast.window="
            toast = true;
            message = $event.detail[0].message || '';
            type = $event.detail[0].type || 'success';
        ">
        <x-toast />
    </div>
</div>
