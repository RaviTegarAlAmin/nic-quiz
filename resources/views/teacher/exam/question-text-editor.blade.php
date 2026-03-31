<div
    x-show="!minimizedQuestion[question.id]"
    x-collapse.duration.300ms
    x-transition:enter="transition-all duration-300 ease-out"
    x-transition:enter-start="opacity-0 -translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition-all duration-200 ease-in"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-2"
    class="grid grid-cols-4 gap-4 mb-4">
    <div class="row-span-2 col-span-3">
        <x-label>Pertanyaan</x-label>

        {{-- Initialize quill editor --}}
        {{-- Later gonna add option button for default and rich-text format --}}
        <div >
            <div class=" bg-white rounded-b-md" x-init="$nextTick(() => initQuillEditors($el, question.id, index))">

            </div>
        </div>


    </div>

    <div>
        <x-label>Tipe Soal</x-label>
        <select
            class="w-full border border-slate-400 focus:border-primary-100 focus:ring-1 focus:ring-primary-400 shadow-sm hover:shadow-md rounded-sm text-sm font-normal py-1 px-2 focus:outline-none"
            x-model="question.type" @change="logQuestionType(question.id, question.type)">
            <template x-for="[label, value] in Object.entries(typeList)" :key="value">
                <option :value="value" x-text="label"></option>
            </template>
        </select>
    </div>

    <div class="mb-4">
        <x-label>Bobot</x-label>
        <x-form-input min="1" type="number" x-model="question.weight"
            @input.debounce.300ms="logQuestionWeight(question.id, question.weight)">

        </x-form-input>

    </div>

    <div class="col-span-4">
        <template x-if="question.type === 'multiple_choice'">
            <div class="grid grid-cols-2 w-full gap-2">
                <template x-for="(option, optionIndex) in (question.options || [])"
                    :key="option.id ?? `${question.id}-${optionIndex}`">
                    <div x-data="{ checkHover: false }" class="relative group">
                        <textarea rows="2" @input.debounce.300ms="logOptionChange(question.id, option.id, option.option)"
                            class="w-full border resize-none border-slate-400  shadow-sm hover:shadow-md rounded-sm text-sm font-normal py-1 px-2 pr-12"
                            x-model="option.option" :name="option.label"
                            :class="checkHover ?
                                'bg-secondary-400 text-primary-400 border-b-8 border-r-4 border-t-secondary-200 border-l-secondary-200 border-b-secondary-600 border-r-secondary-600 outline-none box-border' :
                                ''">
                        </textarea>
                        <div @click="question.ref_answer = option.label; logQuestionRefAnswer(question.id, question.ref_answer)"
                            class="absolute top-2 right-2 text-secondary-400" x-on:mouseover="checkHover = !checkHover"
                            x-on:mouseout="checkHover = !checkHover" :class="checkHover ? 'text-white' : ''">
                            <svg x-show="question.ref_answer == option.label" xmlns="http://www.w3.org/2000/svg"
                                width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-square-check-big-icon lucide-square-check-big">
                                <path d="M21 10.656V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12.344" />
                                <path d="m9 11 3 3L22 4" />
                            </svg>
                            <svg x-show="question.ref_answer != option.label" xmlns="http://www.w3.org/2000/svg"
                                width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-square-icon lucide-square">
                                <rect width="18" height="18" x="3" y="3" rx="2" />
                            </svg>
                        </div>
                    </div>
                </template>
            </div>
        </template>

        <template x-if="question.type === 'essay'">
            <div>
                <x-label>Jawaban</x-label>
                <x-form-input type="textarea" row="2" @input.debounce.300ms="logQuestionRefAnswer(question.id, question.ref_answer)"
                    class="w-full border border-slate-400 focus:border-primary-100 focus:ring-1 focus:ring-primary-400 shadow-sm hover:shadow-md rounded-sm text-sm font-normal py-1 px-2 focus:outline-none"
                    x-model="question.ref_answer"></x-form-input>
            </div>
        </template>
    </div>
</div>
