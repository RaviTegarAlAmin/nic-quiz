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
                                <button type="button" title="Sunting guru"
                                    wire:click="$dispatch('open-teacher-edit', { teacherId: {{ $teacher->id }} })"
                                    class="rounded-md bg-warning-100 p-2 text-warning-700 transition hover:bg-warning-200 hover:text-warning-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                        <path d="m15 5 4 4" />
                                    </svg>
                                </button>
                                <button type="button" title="Hapus guru"
                                    wire:click="$dispatch('open-teacher-delete', { teacherId: {{ $teacher->id }} })"
                                    class="rounded-md bg-danger-100 p-2 text-danger-600 transition hover:bg-danger-200 hover:text-danger-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                        <path d="M3 6h18" />
                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    </svg>
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
