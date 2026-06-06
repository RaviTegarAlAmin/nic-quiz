<div>
    {{-- Header --}}
    <div class="animate-pulse h-11 w-40 bg-gray-300 rounded-xl mb-6"></div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-3">

        {{-- Info Kelas skeleton --}}
        <div class="animate-pulse shadow-md rounded-xl py-5 px-3 bg-white border border-gray-100 space-y-4">
            <div class="h-3 w-20 bg-gray-200 rounded"></div>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-gray-200 shrink-0"></div>
                <div class="space-y-2">
                    <div class="h-4 w-32 bg-gray-200 rounded"></div>
                    <div class="h-3 w-20 bg-gray-200 rounded"></div>
                </div>
            </div>
            <div class="border-t border-gray-100 pt-3 space-y-2">
                <div class="flex justify-between">
                    <div class="h-3 w-20 bg-gray-200 rounded"></div>
                    <div class="h-3 w-28 bg-gray-200 rounded"></div>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <div class="h-16 bg-gray-200 rounded-lg"></div>
                <div class="h-16 bg-pink-100 rounded-lg"></div>
                <div class="h-16 bg-blue-100 rounded-lg"></div>
            </div>
        </div>

        {{-- Daftar Guru skeleton --}}
        <div class="animate-pulse shadow-md rounded-xl py-5 px-3 bg-white border border-gray-100 space-y-4">
            <div class="h-3 w-24 bg-gray-200 rounded"></div>
            @for ($i = 0; $i < 4; $i++)
                <div class="flex items-start justify-between gap-2">
                    <div class="flex items-start gap-2">
                        <div class="w-8 h-8 rounded-full bg-gray-200 shrink-0"></div>
                        <div class="space-y-2">
                            <div class="h-3 w-28 bg-gray-200 rounded"></div>
                            <div class="flex gap-1">
                                <div class="h-5 w-16 bg-gray-200 rounded-full"></div>
                                <div class="h-5 w-14 bg-gray-200 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                    <div class="h-5 w-20 bg-gray-200 rounded-full shrink-0"></div>
                </div>
            @endfor
        </div>

    </div>

    {{-- Daftar Anggota skeleton --}}
    <div class="animate-pulse shadow-md rounded-xl py-5 px-3 bg-white border border-gray-100">
        <div class="h-3 w-36 bg-gray-200 rounded mb-4"></div>
        <div class="rounded-lg overflow-hidden border border-gray-200">
            <div class="h-9 bg-gray-300"></div>
            @for ($i = 0; $i < 8; $i++)
                <div
                    class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} px-4 py-2.5 flex gap-4 border-b border-gray-100">
                    <div class="h-3 w-6 bg-gray-200 rounded"></div>
                    <div class="h-3 w-36 bg-gray-200 rounded"></div>
                    <div class="h-3 w-24 bg-gray-200 rounded"></div>
                    <div class="h-5 w-8 bg-gray-200 rounded-full"></div>
                </div>
            @endfor
        </div>
    </div>

</div>
