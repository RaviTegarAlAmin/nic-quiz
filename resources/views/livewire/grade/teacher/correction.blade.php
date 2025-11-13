<div>
    <!-- Header -->
    <x-header
        class="mb-6 bg-gradient-to-r from-secondary-400 to-secondary-300 text-white border-none rounded-lg shadow-lg px-6 py-4">
        Hasil Ujian {{ $exam->title }}
    </x-header>

    <!-- ExamTaker Info Section -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
        <!-- Left: Photo + Info Card -->
        <div class="relative flex flex-col md:flex-row items-center w-full lg:w-3/4 gap-6">
            <!-- Circle Photo -->
            <div class="relative z-10 -mb-20 md:mb-0">
                <div
                    class="w-40 h-40 rounded-full border-4 border-secondary-400 bg-gray-100 overflow-hidden shadow-xl ring-4 ring-white">
                    <img src="https://via.placeholder.com/150" class="object-cover w-full h-full" alt="Student Photo">
                </div>
            </div>

            <!-- Info Card -->
            <div class="relative w-full md:-ml-16">
                <x-card wire:loading.remove
                    wire:target="currentExamTakerId,previousExamTaker,nextExamTaker,changePerPage"
                    class="w-full min-h-48 pt-20 md:pt-6 px-6 pb-6 text-gray-700 shadow-lg border-t-4 border-secondary-400 hover:shadow-xl transition-shadow duration-200 md:pl-16">
                    <h2 class="text-xl font-bold mb-3 text-gray-800">Info Siswa</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="text-gray-500 font-medium w-16">Nama:</span>
                            <span class="font-semibold text-gray-800">{{ $currentExamTaker->student->name }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-500 font-medium w-16">NIS:</span>
                            <span class="text-gray-800">{{ $currentExamTaker->student->nis }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-500 font-medium w-16">Kelas:</span>
                            <span class="text-gray-800">{{ $currentExamTaker->student->classroom->name }}</span>
                        </div>
                    </div>
                </x-card>

                <!-- Loading State -->
                <x-card wire:loading wire:target="currentExamTakerId,previousExamTaker,nextExamTaker,changePerPage"
                    class="w-full min-h-48 pt-20 md:pt-6 px-6 pb-6 text-gray-700 shadow-lg border-t-4 border-secondary-400 animate-pulse md:pl-16">
                    <div class="space-y-4">
                        <div class="h-6 w-32 bg-gray-300 rounded"></div>
                        <div class="space-y-2">
                            <div class="h-3 w-56 bg-gray-200 rounded"></div>
                            <div class="h-3 w-40 bg-gray-200 rounded"></div>
                            <div class="h-3 w-32 bg-gray-200 rounded"></div>
                        </div>
                    </div>
                </x-card>
            </div>
        </div>

        <!-- Right: Selection + Navigation -->
        <div class="flex flex-col items-center lg:items-end mt-6 lg:mt-0 space-y-4 lg:w-1/4">
            <!-- Student Selector -->
            @if ($examTakers)
                <div class="relative w-full">
                    <select name="examTaker" id="examTaker" wire:model.live="currentExamTakerId"
                        class="w-full appearance-none rounded-lg border border-gray-300 bg-white px-4 py-3 pr-10 text-sm text-gray-700 shadow-md focus:border-secondary-400 focus:ring-2 focus:ring-secondary-400/20 hover:border-secondary-400 cursor-pointer transition-all duration-200">
                        <option value="" disabled selected>Pilih siswa...</option>
                        @foreach ($examTakers as $examTaker)
                            <option value="{{ $examTaker->id }}">
                                {{ $examTaker->student->name }}
                            </option>
                        @endforeach
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="flex justify-center gap-3">
                <button wire:click="previousExamTaker"
                    class="w-12 h-12 rounded-lg bg-gradient-to-r from-secondary-400 to-secondary-300 hover:from-secondary-500 hover:to-secondary-400 disabled:from-gray-300 disabled:to-gray-400 disabled:cursor-not-allowed text-white text-xl font-bold shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center"
                    {{ $examTakers->search(fn($et) => $et->id === $currentExamTakerId) <= 0 ? 'disabled' : '' }}>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                </button>
                <button wire:click="nextExamTaker"
                    class="w-12 h-12 rounded-lg bg-gradient-to-r from-secondary-400 to-secondary-300 hover:from-secondary-500 hover:to-secondary-400 disabled:from-gray-300 disabled:to-gray-400 disabled:cursor-not-allowed text-white text-xl font-bold shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center"
                    {{ $examTakers->search(fn($et) => $et->id === $currentExamTakerId) >= $examTakers->count() - 1 ? 'disabled' : '' }}>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Pagination Links (Top) -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-3">
            <label class="text-sm text-gray-600 font-medium">Tampilkan per halaman:</label>
            <select wire:change="changePerPage($event.target.value)"
                class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-sm focus:border-secondary-400 focus:ring-2 focus:ring-secondary-400/20 hover:border-secondary-400 cursor-pointer transition-all duration-200">
                <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
            </select>
        </div>
        <div class="flex-1 flex justify-end">
            {{ $questions->links() }}
        </div>
    </div>

    <!-- Questions List -->
    <div class="space-y-6">
        @foreach ($questionAnswers as $index => $questionAnswer)
            <div wire:key="question-{{ $questionAnswer['question']['id'] }}">
                <x-card class="transition-all duration-200 border-l-4 border-secondary-400 shadow-md hover:shadow-lg"
                    x-data="{ minimize: $wire.entangle('minimize.{{ $questionAnswer['question']['id'] }}') }">

                    <!-- Card Header -->
                    <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-200">
                        <!-- Question Preview (when minimized) -->
                        <div class="flex items-center gap-3 flex-1">
                            <span
                                class="text-sm font-bold text-secondary-400 bg-secondary-400/10 px-3 py-1 rounded-full">
                                #{{ $questions->firstItem() + $index }}
                            </span>
                            <x-label x-show="minimize" class="text-gray-500 text-sm">
                                {{ Str::length($questionAnswer['question']['question']) > 0 ? substr($questionAnswer['question']['question'], 0, 80) . '...' : 'Soal kosong...' }}
                            </x-label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-3">
                            <!-- Question Type Badge -->
                            <x-tag x-show="minimize"
                                class="bg-secondary-400/10 text-secondary-400 border border-secondary-400/20">
                                {{ $questionAnswer['question']['type'] == 'multiple_choice' ? 'Pilihan Ganda' : 'Esai' }}
                            </x-tag>

                            <!-- Toggle Button -->
                            <button @click="minimize = !minimize"
                                class="text-gray-400 hover:text-secondary-400 transition-colors duration-200 p-1">
                                <svg x-show="!minimize" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m18 15-6-6-6 6" />
                                </svg>
                                <svg x-show="minimize" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div x-show="!minimize" class="space-y-6">
                        <!-- Question Info Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                            <!-- Question Text -->
                            <div class="lg:col-span-3 lg:row-span-2">
                                <x-label class="text-gray-700 font-semibold mb-2">Pertanyaan</x-label>
                                <x-form-input disabled type="textarea" class="bg-gray-50 min-h-[100px]">
                                    {{ $questionAnswer['question']['question'] }}
                                </x-form-input>
                            </div>

                            <!-- Question Type -->
                            <div>
                                <x-label class="text-gray-700 font-semibold mb-2">Tipe Soal</x-label>
                                <div
                                    class="w-full border border-gray-300 bg-gray-50 shadow-sm rounded-lg text-sm font-medium py-2 px-3 text-gray-700">
                                    {{ $questionAnswer['question']['type'] == 'multiple_choice' ? 'Pilihan Ganda' : 'Esai' }}
                                </div>
                            </div>

                            <!-- Weight -->
                            <div>
                                <x-label class="text-gray-700 font-semibold mb-2">Bobot</x-label>
                                <div
                                    class="w-full border border-gray-300 bg-gray-50 shadow-sm rounded-lg text-sm font-medium py-2 px-3 text-gray-700">
                                    {{ $questionAnswer['question']['weight'] }}
                                </div>
                            </div>
                        </div>

                        <!-- Answer Section -->
                        <div class="lg:col-span-4">
                            @if ($questionAnswer['question']['type'] == 'multiple_choice')
                                <!-- Multiple Choice Options -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($questionAnswer['question']->options as $index => $option)
                                        <div class="relative" wire:key="option-{{ $index }}">
                                            <x-form-input type="textarea" row="3" disabled
                                                @class([
                                                    'pr-12 min-h-[80px] transition-all duration-150 bg-gray-50 border border-gray-200 text-gray-700',

                                                    'bg-success-500 text-white border-b-8 border-r-4 border-r-success-600 border-b-success-600' =>
                                                        $option['label'] == $questionAnswer['question']['ref_answer'] &&
                                                        $questionAnswer['answer'] &&
                                                        $option['label'] == $questionAnswer['answer']['answer'],

                                                    'bg-success-50 border-4  border-success-400 text-success-700' =>
                                                        $option['label'] == $questionAnswer['question']['ref_answer'] &&
                                                        (!$questionAnswer['answer'] ||
                                                            $option['label'] != $questionAnswer['answer']['answer']),

                                                    'bg-danger-600/50 text-white border-b-8 border-r-4 border-r-danger-600 border-b-danger-600' =>
                                                        $questionAnswer['answer'] &&
                                                        $option['label'] == $questionAnswer['answer']['answer'] &&
                                                        $option['label'] != $questionAnswer['question']['ref_answer'],
                                                ])>
                                                {{ $option->option }}
                                            </x-form-input>

                                            {{--                                             <!-- Check Icon -->
                                            <div class="absolute top-3 right-3 text-secondary-400">
                                                @if ($questionAnswer['answer']['answer'] == $questionAnswer['question']['ref_answer'])
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="text-green-500">
                                                        <path d="M21 10.656V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12.344" />
                                                        <path d="m9 11 3 3L22 4" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="text-gray-300">
                                                        <rect width="18" height="18" x="3" y="3" rx="2" />
                                                    </svg>
                                                @endif
                                            </div> --}}
                                        </div>
                                    @endforeach
                                </div>
                            @elseif ($questionAnswer['question']['type'] == 'essay')
                                <!-- Essay Answer -->
                                <div>
                                    <x-label class="text-gray-700 font-semibold mb-2">Jawaban</x-label>
                                    <x-form-input disabled type="textarea"
                                        class="bg-gray-50 min-h-[120px]">{{ $questionAnswer['answer']['answer'] }}
                                    </x-form-input>
                                    <div class=" flex justify-end">
                                        <div class=" flex justify-between gap-5">
                                            <x-tag> Nilai Jawaban: {{ $questionAnswer['answer']['score'] }}</x-tag>
                                            <x-tag> Kemiripan Jawaban: {{ $questionAnswer['answer'] }}</x-tag>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </x-card>
            </div>
        @endforeach
    </div>


</div>
