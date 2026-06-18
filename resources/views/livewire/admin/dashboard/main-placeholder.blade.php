<div>
    {{-- Header --}}
    <div class="animate-pulse h-11 w-48 bg-gray-300 rounded-xl mb-6"></div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        <div class="animate-pulse relative overflow-hidden bg-secondary-100 rounded-xl p-4"
            style="box-shadow: 3px 3px 0 #AFA9EC">
            <div class="absolute -right-4 -top-4 w-16 h-16 rounded-full bg-secondary-200 opacity-40"></div>
            <div class="h-8 w-16 bg-secondary-200 rounded mb-2"></div>
            <div class="h-3 w-24 bg-secondary-200 rounded"></div>
        </div>
        <div class="animate-pulse relative overflow-hidden bg-teal-100 rounded-xl p-4"
            style="box-shadow: 3px 3px 0 #5DCAA5">
            <div class="absolute -right-4 -top-4 w-16 h-16 rounded-full bg-teal-200 opacity-40"></div>
            <div class="h-8 w-16 bg-teal-200 rounded mb-2"></div>
            <div class="h-3 w-24 bg-teal-200 rounded"></div>
        </div>
        <div class="animate-pulse relative overflow-hidden bg-warning-100 rounded-xl p-4"
            style="box-shadow: 3px 3px 0 #EF9F27">
            <div class="absolute -right-4 -top-4 w-16 h-16 rounded-full bg-warning-200 opacity-40"></div>
            <div class="h-8 w-16 bg-warning-200 rounded mb-2"></div>
            <div class="h-3 w-24 bg-warning-200 rounded"></div>
        </div>
        <div class="animate-pulse relative overflow-hidden bg-danger-100 rounded-xl p-4"
            style="box-shadow: 3px 3px 0 #F0997B">
            <div class="absolute -right-4 -top-4 w-16 h-16 rounded-full bg-danger-200 opacity-40"></div>
            <div class="h-8 w-16 bg-danger-200 rounded mb-2"></div>
            <div class="h-3 w-24 bg-danger-200 rounded"></div>
        </div>
    </div>

    {{-- Daftar Kelas Header --}}
    <div class="animate-pulse h-10 bg-warning-200 rounded-xl mb-2"></div>

    {{-- Daftar Kelas Table --}}
    <div class="animate-pulse shadow-md rounded-xl bg-white border border-gray-100 mb-6 overflow-hidden">
        <div class="h-9" style="background-color: #AFA9EC"></div>
        @for ($i = 0; $i < 6; $i++)
            <div class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} flex gap-4 px-4 py-2.5 border-b border-gray-100">
                <div class="h-3 w-12 bg-gray-200 rounded"></div>
                <div class="h-3 w-8 bg-gray-200 rounded"></div>
                <div class="h-3 w-32 bg-gray-200 rounded"></div>
                <div class="h-3 w-8 bg-gray-200 rounded ml-auto"></div>
                <div class="h-3 w-8 bg-gray-200 rounded"></div>
                <div class="h-5 w-12 bg-gray-200 rounded-full"></div>
            </div>
        @endfor
    </div>

    {{-- Jadwal Header --}}
    <div class="animate-pulse h-10 bg-warning-200 rounded-xl mb-2"></div>

    {{-- Jadwal --}}
    <div class="animate-pulse shadow-md rounded-xl bg-white border border-gray-100 p-4">
        {{-- Grade tabs --}}
        <div class="flex gap-2 mb-4">
            <div class="h-7 w-16 bg-secondary-200 rounded-lg"></div>
            <div class="h-7 w-16 bg-gray-200 rounded-lg"></div>
            <div class="h-7 w-16 bg-gray-200 rounded-lg"></div>
        </div>

        {{-- Class pills --}}
        <div class="flex gap-2 mb-5">
            <div class="h-6 w-6 bg-gray-200 rounded-lg"></div>
            <div class="h-6 w-10 bg-secondary-100 rounded-full"></div>
            <div class="h-6 w-10 bg-gray-200 rounded-full"></div>
            <div class="h-6 w-10 bg-gray-200 rounded-full"></div>
            <div class="h-6 w-6 bg-gray-200 rounded-lg"></div>
        </div>

        {{-- Timeline rows --}}
        <div class="space-y-3">
            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                <div class="flex items-center gap-3">
                    <div class="h-3 w-12 bg-gray-200 rounded shrink-0"></div>
                    <div class="flex gap-2 flex-wrap">
                        @for ($i = 0; $i < rand(3, 5); $i++)
                            <div class="h-10 w-16 bg-gray-200 rounded-lg"></div>
                        @endfor
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
