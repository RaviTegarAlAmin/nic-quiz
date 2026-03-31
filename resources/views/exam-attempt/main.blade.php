@extends('exam-attempt.layout')

@section('header')
    <div class="mx-auto grid grid-cols-1 gap-3 md:grid-cols-[1fr_auto] md:items-start">
        <div class="order-1 min-w-0">
            <div>
                <h1 class="text-left text-xl font-bold text-white ml-3 md:text-2xl">
                    {{ $exam->title }}
                </h1>
            </div>
        </div>

        <div class="order-2 flex justify-start md:justify-end">
            <a href="{{ route('student.exams.index') }}" class="m-1 inline-block">
                <x-button variant="danger" class="w-auto hover:underline inline-flex items-center gap-2 px-4 py-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-arrow-left">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg>
                    <span>Kembali ke Daftar Ujian</span>
                </x-button>
            </a>
        </div>
    </div>
@endsection

@push('styles')
    <style src="resources/css/quill-question-viewer.css">
    </style>
@endpush

@section('content')
    @if ($examTaker->status == 'ongoing')
        <div class="grid md:grid-cols-4 grid-cols-1 md:gap-4 gap-1" x-data="examAttempt({
            questions: {{ Illuminate\Support\Js::from($questions) }},
            answers: {{ Illuminate\Support\Js::from($answers->keyBy('question_id')) }},
            exam_taker_id: {{ Illuminate\Support\Js::from($examTaker->id) }},
            exam_taker_status: {{ Illuminate\Support\Js::from($examTaker->status) }},
            student_id: {{ Illuminate\Support\Js::from($examTaker->student_id) }},
            startAt: {{ Illuminate\Support\Js::from(\Illuminate\Support\Carbon::parse($examTaker->start_at, 'UTC')->getTimestampMs()) }},
            duration: {{ Illuminate\Support\Js::from($examTaker->examAssignment->duration) }}
        })">

            <div class="col-span-3">
                <template x-if="!currentQuestion">
                    <x-card class="text-slate-500">
                        Belum ada soal tersedia.
                    </x-card>
                </template>

                <template x-if="currentQuestion">
                    <div>
                        <x-card class="mb-4 text-slate-600">
                            <div class="flex justify-between">
                                <x-tag class="mb-4">
                                    <span x-text="`Pertanyaan ${currentIndex + 1}`"></span>
                                </x-tag>

                                <div class="-mt-5" title="Marked Question" @click="markQuestion()">
                                    <svg x-show="answers[currentQuestion.id]?.marked === true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="lucide lucide-bookmark w-10 h-10 text-warning-600 hover:cursor-pointer"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" />
                                    </svg>

                                    <svg x-show="answers[currentQuestion.id]?.marked !== true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="lucide lucide-bookmark w-10 h-10 text-secondary-400 hover:cursor-pointer "
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" />
                                    </svg>
                                </div>
                            </div>

                            <hr class="border-slate-300 border rounded-md mb-3">

                            <div class="h-30 max-h-64 overflow-y-auto text-lg mb-2">
                                <div
                                    x-ref="questionViewer"
                                    x-init="$nextTick(() => initQuestionViewer($el))"
                                    x-effect="renderCurrentQuestion()"
                                    class="student-question-viewer"></div>
                            </div>

                            <p class="text-end text-slate-400 cursor-default">
                                {{ $answers->whereNotNull('answer')->count() }} Dari {{ $questions->count() }} Soal
                                Terjawab
                            </p>
                        </x-card>

                        <x-card class="mb-4">
                            <template x-if="currentQuestion.type === 'multiple_choice'">
                                <div class="grid grid-cols-1 md:grid-cols-2 w-full md:gap-2 gap-1">
                                    <template x-for="option in currentQuestion.options"
                                        :key="`${currentQuestion.id}-${option.id}`">
                                        <div class="relative group border-4 border-transparent hover:border-gray-400 rounded-lg"
                                            @click="currentAnswer.answer = option.label">
                                            <div class="w-full h-full min-h-14 border border-primary-100 ring-1 ring-slate-300 shadow-sm rounded-md text-sm font-normal py-1 pr-10 pl-2"
                                                :class="currentAnswer?.answer == option.label ?
                                                    'bg-secondary-400 text-primary-400 border-b-8 border-r-4 border-t-secondary-200 border-l-secondary-200 border-b-secondary-600 border-r-secondary-600 outline-none box-border' :
                                                    ''">
                                                <span x-text="option.option"></span>
                                            </div>

                                            <div class="absolute top-2 right-2"
                                                :class="currentAnswer?.answer == option.label ? 'text-white' :
                                                    'text-secondary-400'">
                                                <svg x-show="currentAnswer?.answer == option.label"
                                                    xmlns="http://www.w3.org/2000/svg" width="35" height="35"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-square-check-big-icon lucide-square-check-big">
                                                    <path
                                                        d="M21 10.656V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12.344" />
                                                    <path d="m9 11 3 3L22 4" />
                                                </svg>

                                                <svg x-show="currentAnswer?.answer != option.label"
                                                    xmlns="http://www.w3.org/2000/svg" width="35" height="35"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-square-icon lucide-square">
                                                    <rect width="18" height="18" x="3" y="3" rx="2" />
                                                </svg>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>

                            <template x-if="currentQuestion.type === 'essay'">
                                <div>
                                    <textarea rows="4"
                                        class="w-full h-full border border-primary-100 ring-1 ring-slate-300 focus:border-primary-400 focus:ring-1 focus:ring-primary-400 shadow-sm hover:shadow-md rounded-md text-sm font-normal py-1 px-2 resize-none"
                                        x-model="currentAnswer.answer"></textarea>
                                </div>
                            </template>
                        </x-card>

                        <div class="flex justify-between col-span-3">
                            <button type="button" @click="prevQuestion()" :disabled="currentIndex === 0"
                                class="py-1 px-5 text-secondary-400 disabled:text-slate-400">
                                <div class="flex gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-big-left-dash-icon lucide-arrow-big-left-dash pt-1">
                                        <path
                                            d="M13 9a1 1 0 0 1-1-1V5.061a1 1 0 0 0-1.811-.75l-6.835 6.836a1.207 1.207 0 0 0 0 1.707l6.835 6.835a1 1 0 0 0 1.811-.75V16a1 1 0 0 1 1-1h2a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1z" />
                                        <path d="M20 9v6" />
                                    </svg>
                                    <p>Previous</p>
                                </div>
                            </button>

                            <button type="button" @click="nextQuestion()"
                                :disabled="currentIndex >= questions.length - 1"
                                class="py-1 px-5 text-secondary-400 disabled:text-slate-400">
                                <div class="flex gap-1">
                                    <p>Next</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-arrow-big-right-dash-icon lucide-arrow-big-right-dash pt-1">
                                        <path
                                            d="M11 9a1 1 0 0 0 1-1V5.061a1 1 0 0 1 1.811-.75l6.836 6.836a1.207 1.207 0 0 1 0 1.707l-6.836 6.835a1 1 0 0 1-1.811-.75V16a1 1 0 0 0-1-1H9a1 1 0 0 1-1-1v-4a1 1 0 0 1 1-1z" />
                                        <path d="M4 9v6" />
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <div>
                <x-card class="font-bold text-4xl mb-2 flex justify-between">
                    <p class="text-slate-600">Daftar Soal</p>
                    <div @click="toggleQuestionList">

                        <template x-if="showQuestionList">
                            <span title="Question List" class="text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-chevron-up hover:text-gray-400 hover:cursor-pointer">
                                    <path d="m18 15-6-6-6 6" />
                                </svg>
                            </span>
                        </template>

                        <template x-if="!showQuestionList">
                            <span title="Question List" class="text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-chevron-down-icon lucide-chevron-down hover:text-gray-400 hover:cursor-pointer">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </span>
                        </template>
                    </div>
                </x-card>

                <div class="overflow-hidden mb-2">
                    <x-card x-show="showQuestionList"
                        class="grid md:grid-cols-4 grid-cols-6 gap-2 overflow-y-auto max-h-80">
                        <template x-for="(question, index) in questions" :key="question.id">
                            <button type="button" @click="currentIndex = index"
                                class="shadow-none border border-slate-400 text-center font-bold text-secondary-400 transition relative rounded-md py-4 px-2"
                                :class="{
                                    'bg-success-600 text-white': answers[question.id]?.answer,
                                    'ring-4 ring-offset-0 ring-primary-600': index === currentIndex
                                }">
                                <span x-text="index + 1"></span>

                                <span x-show="answers[question.id]?.marked === true"
                                    class="absolute p-0 m-0 top-1/2 -mt-12 -mr-1 right-1 text-5xl text-warning-600">
                                    &#x2022;
                                </span>
                            </button>
                        </template>
                    </x-card>
                </div>

                <x-card class="text-5xl bg-black flex justify-between">
                    <p class="text-md text-slate-600 font-bold">Duration</p>
                    <div>
                        <span x-text="`${remainingHours} : ${remainingMinutes} : ${remainingSeconds}`"></span>
                    </div>
                </x-card>

                <div class="mt-2">
                    <x-button
                        @click="
                    submit_form = true;
                    submit_type = 'manual';
                "
                        variant="secondary" class=" w-full">
                        Submit
                    </x-button>
                </div>
            </div>

            <x-exam-attempt.submit-form />
        </div>
    @else
        Ujian sudah disubmit atau sudah berakhir
    @endif
@endsection
