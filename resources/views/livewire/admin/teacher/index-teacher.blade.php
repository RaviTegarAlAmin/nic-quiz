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
            <div class="inline-flex overflow-hidden rounded-lg border border-slate-300 shadow">
                <button type="button" wire:click="openAddModal"
                    class="inline-flex items-center gap-2 bg-secondary-400 px-4 py-2 text-sm font-semibold text-white transition hover:bg-secondary-500">
                    <span class="text-lg leading-none">+</span>
                    Tambah Guru
                </button>
                <button type="button" wire:click="openUploadModal"
                    class="inline-flex items-center gap-2 border-l border-success-600 bg-success-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-success-700">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-file-up-icon lucide-file-up">
                            <path
                                d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                            <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                            <path d="M12 12v6" />
                            <path d="m15 15-3-3-3 3" />
                        </svg>
                    </span>
                    Upload
                </button>
                <a href="{{ route('admin.download.teachers') }}"
                    class="inline-flex items-center gap-2 border-l border-slate-300 bg-primary-700 px-4 py-2 text-sm font-semibold text-white transition hover:bg-primary-800">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-file-down-icon lucide-file-down">
                            <path
                                d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                            <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                            <path d="M12 18v-6" />
                            <path d="m9 15 3 3 3-3" />
                        </svg>
                    </span>
                    Download
                </a>
            </div>
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

    <div x-data="{ modalform: $wire.entangle('modalUpload') }" x-cloak>
        <x-modal-form formName="Upload Data Guru">
            <livewire:admin.teacher.upload />
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
