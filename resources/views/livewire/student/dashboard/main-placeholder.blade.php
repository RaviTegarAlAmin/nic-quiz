<div>
    {{-- Header --}}
    <div class="animate-pulse h-11 w-56 bg-gray-300 rounded-xl mb-6"></div>

    <div class="grid lg:grid-cols-5 grid-cols-2 gap-3">

        {{-- Left col --}}
        <div class="lg:col-span-3 col-span-2 flex flex-col gap-3">

            {{-- Statistik Ujian card --}}
            <div class="animate-pulse border border-gray-200 rounded-xl p-4 space-y-3">
                <div class="h-3 w-28 bg-gray-300 rounded"></div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="h-20 bg-gray-300 rounded-xl"></div>
                    <div class="h-20 bg-gray-300 rounded-xl"></div>
                </div>
                <div class="grid grid-cols-4 gap-3">
                    <div class="h-14 bg-gray-300 rounded-xl"></div>
                    <div class="h-14 bg-gray-300 rounded-xl"></div>
                    <div class="h-14 bg-gray-300 rounded-xl"></div>
                    <div class="h-14 bg-gray-300 rounded-xl"></div>
                </div>
            </div>

            {{-- Rata-Rata chart card --}}
            <div class="animate-pulse border border-gray-200 rounded-xl p-4 space-y-3">
                <div class="h-3 w-36 bg-gray-300 rounded"></div>
                @foreach ([75, 60, 15, 50, 10, 5] as $w)
                    <div class="flex items-center gap-3">
                        <div class="h-3 w-20 bg-gray-300 rounded shrink-0"></div>
                        <div class="h-5 bg-gray-300 rounded" style="width: {{ $w }}%"></div>
                    </div>
                @endforeach
            </div>

        </div>

        {{-- Right col --}}
        <div class="col-span-2 flex flex-col gap-3">

            {{-- Ujian Aktif card --}}
            <div class="animate-pulse border border-gray-200 rounded-xl p-4 space-y-3">
                <div class="h-3 w-24 bg-gray-300 rounded"></div>
                @for ($i = 0; $i < 3; $i++)
                    <div class="flex justify-between items-center">
                        <div class="space-y-2">
                            <div class="h-3 w-32 bg-gray-300 rounded"></div>
                            <div class="h-2.5 w-20 bg-gray-300 rounded"></div>
                        </div>
                        <div class="h-8 w-20 bg-gray-300 rounded-full"></div>
                    </div>
                @endfor
            </div>

            {{-- Aktivitas Terakhir card --}}
            <div class="animate-pulse border border-gray-200 rounded-xl p-4 space-y-3">
                <div class="h-3 w-28 bg-gray-300 rounded"></div>
                @for ($i = 0; $i < 4; $i++)
                    <div class="flex justify-between items-center">
                        <div class="space-y-2">
                            <div class="h-3 w-28 bg-gray-300 rounded"></div>
                            <div class="h-2.5 w-20 bg-gray-300 rounded"></div>
                        </div>
                        <div class="h-6 w-10 bg-gray-300 rounded-lg"></div>
                    </div>
                @endfor
            </div>

        </div>

    </div>
</div>
