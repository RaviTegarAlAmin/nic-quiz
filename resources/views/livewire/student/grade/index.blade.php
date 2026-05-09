<div>
    <x-header>
        Data Nilai {{ $student->name }}
    </x-header>


    {{-- Utility --}}
    <div x-data="{ order: $wire.entangle('order') }"
        class="grid md:grid-cols-9 grid-cols-4 mx-auto py-5 px-2 pb-2 gap-3 border bg-white border-gray-100 rounded-md border-t-2 border-t-secondary-400 shadow-md shadow-gray-200 mb-6">

        {{-- Search Bar --}}
        <div class="md:col-span-5 col-span-4">
            <form wire:submit="search" class="relative w-full">
                <div class="relative">
                    <x-form wire:model="query" label="Cari Ujian" name="query" type="text" placeholder="Cari Ujian">
                    </x-form>

                    <button type="submit" class="absolute right-3 bottom-3 p-0 rounded transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="lucide lucide-search-icon lucide-search text-gray-300 hover:text-gray-400 cursor-pointer">
                            <path d="m21 21-4.34-4.34" />
                            <circle cx="11" cy="11" r="8" />
                        </svg>
                    </button>
                </div>
            </form>

        </div>

        {{-- Sort By --}}
        <div class="md:col-span-4 col-span-4">
            <form wire:submit="sortBy" class="flex gap-3">
                <x-floating-select wire:model="sortCategory" label="Urutkan Berdasarkan" name="field" class="flex-1">
                    <option value="finished_at">Waktu Selesai</option>
                    <option value="course">Pelajaran</option>
                    <option value="name">Nama Ujian</option>
                    <option value="score">Nilai</option>
                </x-floating-select>

                {{-- Sort Direction Toggle --}}
                <button type="button" @click="order = (order === 'asc' ? 'desc' : 'asc')"
                    class="w-12 flex items-center justify-center rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" class="transition-transform"
                        :class="{ 'rotate-180': order === 'desc' }">
                        <path d="m5 12 7-7 7 7" />
                        <path d="M12 19V5" />
                    </svg>
                </button>

                {{-- Submit Button --}}
                <button type="submit"
                    class="w-16 flex items-center justify-center font-semibold rounded-lg px-3 py-2 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 bg-secondary-400 text-white border border-secondary-600 hover:bg-secondary-500 focus:ring-secondary-400 shadow-sm hover:shadow">
                    Sort
                </button>
            </form>
        </div>

        @if ($searchDescription && $currentExamsData)
            <p class=" md:col-span-5 col-span-4 text-sm text-gray-400 -mt-2">
                {{ $searchDescription  }}
            </p>
        @else
            <p class=" md:col-span-5 col-span-4 text-sm  opacity-0 -mt-2">
                {{ 'Tidak ada data' }}
            </p>
        @endif


    </div>





    {{-- Data Cards --}}

    @if ($currentExamsData)

        @foreach ($currentExamsData as $exam)
            <div class="w-full hover:shadow-md transition-shadow duration-200 bg-white mx-auto py-1 px-2 gap-3 border border-gray-200 rounded-md shadow-sm shadow-gray-200 mb-3"
                wire:key="{{ $exam['id'] }}">
                <div class="flex items-center gap-4">

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <div class="md:w-32 w-16">
                                <x-tag class="text-xs">
                                    {{ $exam['course'] ?? 'N/A' }}
                                </x-tag>
                            </div>

                            <div>
                                <h3 class="font-semibold text-base text-gray-800 truncate">
                                    {{ $exam['name'] ? substr($exam['name'], 0, 50) : 'N/A' }}
                                </h3>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $exam['finished_at'] ? \Carbon\Carbon::parse($exam['finished_at'])->format('d M Y, H:i') : 'N/A' }}
                                </p>
                            </div>

                        </div>
                    </div>

                    {{-- Score Badge & Button --}}
                    <div class="flex-shrink-0 flex flex-col items-center gap-2 -mt-2">
                        <div
                            class="w-12 h-12 flex items-center justify-center rounded-lg shadow-sm {{ $exam['score'] >= 75 ? 'bg-gradient-to-br from-success-500 to-success-600' : 'bg-gradient-to-br from-danger-500 to-danger-600' }}">
                            <span class="text-l font-bold text-white">
                                {{ round($exam['score'], 0) ?? '-' }}
                            </span>
                        </div>

{{--                         <button wire:click="viewDetail({{ $exam['id'] }})"
                            class="text-xs text-secondary-400 hover:text-secondary-500 font-medium hover:underline transition">
                            Lihat Detail
                        </button> --}}
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <x-response.no-data>

        </x-response.no-data>

    @endif

</div>
