<div class=" mt-4">
    @if ($questions)
        @foreach ($questions as $index => $question)
            <div wire:key="question={{ $question['id'] ?? $index }}" wire:transition.duration.500ms>

                <x-card x-data="{ minimize: false }">
                    {{-- Header function --}}
                    <div class="flex justify-between -mt-4 py-2">
                        {{-- Question Number and Question Preview --}}
                        <div class="flex gap-2 align-middle">
                            <x-label>{{ $index + 1 }}</x-label>
                            <x-label x-show="minimize == true"
                                class=" text-slate-400">{{ substr($question['question'], 0, 50) . '...' }}</x-label>
                        </div>
                        {{-- Button for minimize, delete, and duplicate --}}
                        <div>

                        </div>

                    </div>
                    <hr class=" bg-secondary-200 w-full mx-auto h-0.5 mb-3">
                    {{-- Body Function For Question General Info --}}
                    <div class=" grid grid-cols-2 gap-4 mb-4">

                        <div class=" row-span-2">
                            <x-label>Pertanyaan</x-label>
                            <x-form-input type="textarea"
                                wire:model.live="questions.{{ $index }}.question"></x-form-input>
                        </div>
                        <div>
                            <x-label>Tipe Soal</x-label>
                            <select wire:model.live="questions.{{ $index }}.type" id="question.type"
                                class="w-full border border-slate-400 focus:border-primary-100 focus:ring-1 focus:ring-primary-400 shadow-sm hover:shadow-md rounded-sm text-sm font-normal py-1 px-2 focus:outline-none">
                                @foreach ($typeList as $label => $type)
                                    <option value="{{ $type }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <input type="text" wire:model.live="questions.{{ $index }}.weight">
                        </div>
                        {{-- Specific Question Related --}}
                        <div>
                            @if ($question['type'] == 'multiple_choice')
                                This Is Multiple choice
                            @elseif ($question['type'] == 'essay')
                                This is Essay
                            @endif
                        </div>
                    </div>

                </x-card>
            </div>
        @endforeach
    @else
        <div class=" text-center text-slate-400 py-5">
            <p class="mb-5">Tidak ada pertanyaan</p>
            <hr class=" mx-auto w-3/4 h-0.5 bg-secondary-300-0.75">
        </div>
    @endif

    <div wire:click="addQuestion"
        class=" text-xl text-slate-200 rounded-md text-center py-6 border-4 border-dashed border-slate-150 hover:text-secondary-400 hover:border-secondary-300 cursor-pointer">
        <p class=" text-4xl">+</p>
        <p>Tambah Pertanyaan</p>
    </div>
</div>
