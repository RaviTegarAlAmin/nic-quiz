<div>
    {{-- Question --}}
    <x-card class=" h-56 max-h-80 overflow-y-auto mb-4">
        <div class=" mb-4">
            {{ $number + 1 }}
        </div>
        <hr class=" border-slate-300 border rounded-md mb-3">
        <div class=" text-lg">
            {{ $question['question'] }}
        </div>
    </x-card>

    {{-- Answer Field --}}

    <x-card>
        @if ($question['type'] == 'multiple_choice')
            <div class=" grid grid-cols-1 md:grid-cols-2 w-full md:gap-2 gap-1">
                @foreach ($question['options'] as $index => $option)
                    <div x-data="{ checkHover: false }" class=" relative group">
                        <div class="w-full h-full min-h-14 border border-primary-100 ring-1 ring-slate-300 focus:border-primary-400 focus:ring-1 focus:ring-primary-400 shadow-sm hover:shadow-md rounded-md text-sm font-normal py-1 pr-10 pl-2 "
                            wire:key="option-{{ $question['id'] }}-{{ $index }}"
                            x-bind:class="checkHover
                                ?
                                'bg-secondary-400 text-primary-400 border-b-8 border-r-4 border-t-secondary-200 border-l-secondary-200 border-b-secondary-600 border-r-secondary-600 outline-none box-border' :
                                ''">
                            {{ $option['option'] }}
                        </div>

                        <div class=" absolute top-2 right-2 text-secondary-400" x-on:mouseover="checkHover= !checkHover"
                            x-on:mouseout="checkHover = !checkHover"
                            wire:click="toggleCorrectAnswer({{ $option['label'] }})"
                            x-bind:class="checkHover ? ' text-white' : ''">
                            @if ($currentAnswer == $option['label'])
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-square-check-big-icon lucide-square-check-big">
                                    <path d="M21 10.656V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12.344" />
                                    <path d="m9 11 3 3L22 4" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-square-icon lucide-square">
                                    <rect width="18" height="18" x="3" y="3" rx="2" />
                                </svg>
                            @endif
                        </div>
                    </div>
                @endforeach

            </div>
        @else
            {{-- Essay --}}

            <div>
                <x-form-input
                wire:model.live.debounce.200ms="currentAnswer"
                type="textarea" col="30" row="4" ></x-form-input>
            </div>
        @endif
    </x-card>

</div>
