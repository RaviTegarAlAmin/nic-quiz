<div>

    <x-card>
        <div class="grid grid-cols-3 gap-3">
            <div class="col-span-2 flex">
                <div><x-label for="title" class="mr-3">Judul</x-label></div>
                <div class="flex-1">
                    <x-form-input name="title" type="text" id="title" wire:model.blur="title"
                        placeholder="Tulis nama ujian..." />
                </div>
            </div>

            <div class="flex">
                <div><x-label for="courseId" class="mr-3">Mata Pelajaran</x-label></div>
                <div class="flex-1">
                    <select wire:model="courseId" id="courseId"
                        class="w-full border border-slate-400 focus:border-primary-100 focus:ring-1 focus:ring-primary-400 shadow-sm hover:shadow-md rounded-sm text-sm font-normal py-1 px-2 focus:outline-none">
                        <option value="">Piih Mata Pelajaran...</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex">
                <div><x-label for="start_at" class="mr-3">Mulai</x-label></div>
                <div class="flex-1">
                    <x-form-input type="datetime-local" id="start_at" wire:model="start_at" name="start_at"
                        placeholder="Waktu mulai..." />
                </div>
            </div>

            <div class="flex">
                <div><x-label for="end_at" class="mr-3">Akhir</x-label></div>
                <div class="flex-1">
                    <x-form-input name="end_at" type="datetime-local" id="end_at" wire:model.blur="end_at" />
                </div>
            </div>

            <div class="flex">
                <div><x-label for="duration" class="mr-3">Durasi</x-label></div>
                <div class="flex-1">
                    <x-form-input name="duration" type="number" id="duration" wire:model.blur="duration"
                        placeholder="Waktu dalam menit..." />
                </div>
            </div>
        </div>

        <x-submit-button wire:click="addExam">Buat Ujian Baru</x-submit-button>
    </x-card>


</div>
