<div>
    <div class="mb-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <x-tag>Daftar Guru</x-tag>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama, NIP, atau alamat..."
            class="w-full rounded-lg border border-slate-300 px-4 py-2 text-sm shadow-sm md:w-80">
    </div>

    <div class="overflow-x-auto">
        <table class="w-full overflow-hidden rounded-xl border-separate border-spacing-0 border-r-8 border-r-secondary-500/60 shadow-lg">
            <thead class="bg-secondary-400 text-sm font-semibold text-white">
                <tr>
                    <th class="px-4 py-4 text-left">Guru</th>
                    <th class="px-4 py-4">NIP</th>
                    <th class="px-4 py-4">Gender</th>
                    <th class="px-4 py-4">Tanggal Lahir</th>
                    <th class="px-4 py-4 text-left">Alamat</th>
                    <th class="px-4 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($teachers as $teacher)
                    <tr class="odd:bg-white even:bg-slate-100 hover:bg-slate-50">
                        <td class="whitespace-nowrap border px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="h-12 w-12 overflow-hidden rounded-full border border-slate-200 bg-slate-100">
                                    <img src="{{ asset('Assets/Logo/default-profile.png') }}" alt="Teacher avatar"
                                        class="h-full w-full object-cover">
                                </div>
                                <div class="text-left">
                                    <p class="font-semibold text-slate-700">{{ $teacher->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $teacher->user?->email ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap border px-4 py-3 text-center">{{ $teacher->nip }}</td>
                        <td class="whitespace-nowrap border px-4 py-3 text-center">{{ $teacher->gender }}</td>
                        <td class="whitespace-nowrap border px-4 py-3 text-center">{{ $teacher->born_date }}</td>
                        <td class="border px-4 py-3 text-left">{{ $teacher->address }}</td>
                        <td class="whitespace-nowrap border px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" wire:click="$dispatch('open-teacher-edit', { teacherId: {{ $teacher->id }} })"
                                    class="rounded-md bg-amber-100 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-200">
                                    Edit
                                </button>
                                <button type="button" wire:click="$dispatch('open-teacher-delete', { teacherId: {{ $teacher->id }} })"
                                    class="rounded-md bg-danger-100 px-3 py-2 text-xs font-semibold text-danger-600 transition hover:bg-danger-200">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="border px-4 py-10 text-center text-sm text-slate-400">
                            Belum ada data guru.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
