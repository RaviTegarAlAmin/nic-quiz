<div x-data="questionEditor({
    questions: {{ Illuminate\Support\Js::from($questions) }},
    teacher_id: {{ Illuminate\Support\Js::from($teacher->id) }},
    exam_id: {{ Illuminate\Support\Js::from($exam->id) }},
    exam_title: {{ Illuminate\Support\Js::from($exam->title) }},
    typeList: {{ Illuminate\Support\Js::from(['Pilihan Ganda' => 'multiple_choice', 'Esai' => 'essay']) }}

})">
    <div class="mt-4" x-show="editorReady" style="display: none;">
        <div class="sticky top-0 z-10 mb-4">
            <x-card class="border border-slate-200/80 hover:bg-gray-200 bg-transparent backdrop-blur">
                <div class="flex items-center justify-between gap-4">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-slate-700 truncate" x-text="exam_title"></p>
                        <p class="text-xs text-slate-400">
                            <span x-show="saveStatus === 'idle'">Belum ada perubahan tersimpan</span>
                            <span x-show="saveStatus === 'saving'"> Menyimpan perubahan...</span>
                            <span x-show="saveStatus === 'saved'">Disimpan terakhir pada <span x-text="lastSavedAt"></span></span>
                            <span x-show="saveStatus === 'error'">Gagal menyimpan perubahan</span>
                        </p>
                    </div>

                    <x-button variant="secondary" @click="autoSave" x-bind:disabled="saving">
                        <span x-show="!saving">Simpan</span>
                        <span x-show="saving">Menyimpan...</span>
                    </x-button>
                </div>
            </x-card>
        </div>
        <template x-if="editorReady && questions.length > 0">
            <div>
                <template x-for="(question, index) in questions" :key="question.id">
                    <div>
                        <x-card
                            class="mb-8 transition border-t-8 border-secondary-400 border-b-8 drop-shadow-xl border-b-gray-400">
                            {{-- Header Function --}}
                            <div class="flex justify-between -mt-4 py-2">
                                <div class="flex gap-2 align-middle">
                                    <x-label x-text="index + 1"></x-label>
                                    <x-label x-show="minimizedQuestion[question.id]" class="text-slate-400"
                                        x-text="getRawQuestionPreview(question.question)"></x-label>
                                </div>

                                <div class="flex gap-2">
                                    <div>
                                        <x-tag x-show="minimizedQuestion[question.id]"
                                            x-text="question.type === 'multiple_choice' ? 'Pilihan Ganda' : 'Esai'"></x-tag>
                                    </div>
                                    <div @click="toggleMinimizeQuestion(question.id)">
                                        <span title="Minimize"
                                            class="text-slate-400 cursor-pointer hover:text-slate-600 focus:text-slate-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-chevron-up transition-transform duration-300 ease-out"
                                                :class="{ 'rotate-180': minimizedQuestion[question.id] }">
                                                <path d="m18 15-6-6-6 6" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div>
                                        <span title="Hapus Pertanyaan" @click="addDeletedQuestion(question.id,index)"
                                            class="text-slate-400 cursor-pointer hover:text-danger-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-trash2-icon lucide-trash-2">
                                                <path d="M10 11v6" />
                                                <path d="M14 11v6" />
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <hr class="bg-secondary-200 w-full mx-auto h-0.5 mb-3">

                            {{-- Question Text Editor --}}
                            @include('teacher.exam.question-text-editor')
                        </x-card>
                    </div>
                </template>
            </div>
        </template>

        <template x-if="editorReady && questions.length === 0">
            <div class="text-center text-slate-400 py-5">
                <p class="mb-5">Tidak ada pertanyaan</p>
                <hr class="mx-auto w-3/4 h-0.5 bg-secondary-300-0.75">
            </div>
        </template>

        <div @click="addQuestion()"
            class="text-xl text-slate-200 rounded-md text-center py-6 border-4 border-dashed border-slate-150 hover:text-secondary-400 hover:border-secondary-300 cursor-pointer">
            <p class="text-4xl">+</p>
            <p>Tambah Pertanyaan</p>
        </div>
    </div>
</div>
