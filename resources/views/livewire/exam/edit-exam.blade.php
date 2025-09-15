<div>
    <x-card>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div class="col-span-2 flex flex-col lg:flex-row">
                <div><x-label for="title" class="mr-3">Judul</x-label></div>
                <div class="flex-1">
                    <x-form-input name="title" type="text" id="title" wire:model.blur="title" :disabled="$examlocked" />
                </div>
            </div>

            <div class="flex flex-col lg:flex-row">
                <div class="flex gap-0">
                    <x-label for="courseId" class="mr-0">Mata Pelajaran</x-label>
                    <div class=" p-1.5 mr-3 text-secondary-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-lock-keyhole-icon lucide-lock-keyhole">
                            <circle cx="12" cy="16" r="1" />
                            <rect x="3" y="10" width="18" height="12" rx="2" />
                            <path d="M7 10V7a5 5 0 0 1 10 0v3" />
                        </svg>

                    </div>
                </div>
                <div class="flex-1">
                    <x-form-input name="{{ $courseName }}" :value="$courseName" disabled></x-form-input>
                </div>
            </div>

        </div>

        @if ($examlocked)
            <div class=" flex gap-2" x-data="{ modal: false }">
                <x-submit-button wire:click="unlockExam">Sunting Ujian</x-submit-button>
                <x-submit-button x-on:click="modal = !modal" class=" bg-red-700 hover:bg-red-900 w-1/6">Hapus
                    Ujian</x-submit-button>

                <x-modal :message="'Hapus Ujian?'">
                    <x-submit-button class=" bg-red-700" wire:click="deleteExam">Ya</x-submit-button>
                </x-modal>
            </div>
            @else
                <div class=" flex gap-2">
                    <x-submit-button wire:click="updateExam">Simpan Perubahan</x-submit-button>
                    <x-submit-button class=" w-1/5" wire:click="resetData">Reset Data</x-submit-button>
                    <x-submit-button class=" w-1/5" wire:click="lockExam">Batal</x-submit-button>
                </div>

        @endif


    </x-card>


    @livewire('question.add-question', ['exam' => $exam])



</div>
