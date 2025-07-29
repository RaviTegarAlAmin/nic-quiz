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
                <div><x-label for="courseId" class="mr-3">Mata Pelajaran</x-label></div>
                <div class="flex-1">
                    <x-form-input name="{{ $courseName }}" :value="$courseName" disabled></x-form-input>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row">
                <div><x-label for="start_at" class="mr-3">Mulai</x-label></div>
                <div class="flex-1">
                    <x-form-input type="datetime-local" id="start_at" wire:model.blur="start_at" name="start_at"
                        placeholder="Waktu mulai..." :disabled="$examlocked" />
                </div>
            </div>

            <div class="flex flex-col lg:flex-row">
                <div><x-label for="end_at" class="mr-3">Akhir</x-label></div>
                <div class="flex-1">
                    <x-form-input name="end_at" type="datetime-local" id="end_at" wire:model.blur="end_at"
                        :disabled="$examlocked" />
                </div>
            </div>

            <div class="flex flex-col lg:flex-row">
                <div><x-label for="duration" class="mr-3">Durasi</x-label></div>
                <div class="flex-1">
                    <x-form-input name="duration" type="number" id="duration" wire:model="duration" :disabled="$examlocked"
                        placeholder="Waktu dalam menit..." />
                </div>
            </div>
        </div>

        @if ($examlocked)
            <div class=" flex gap-2">
                <x-submit-button wire:click="unlockExam">Sunting Ujian</x-submit-button>
                <x-submit-button class=" w-1/3" wire:click="deleteExam">Hapus Ujian</x-submit-button>
            </div>
        @else
            <div class=" flex gap-2">
                <x-submit-button wire:click="updateExam">Simpan Perubahan</x-submit-button>
                <x-submit-button class=" w-1/6" wire:click="resetData">Reset Data</x-submit-button>
                <x-submit-button class=" w-1/6" wire:click="lockExam">Batal</x-submit-button>
            </div>
        @endif


    </x-card>


</div>
