document.addEventListener('alpine:init', () => {
    Alpine.data('questionEditor', ({
        questions = [],
        teacher_id = null,
        exam_id,
        exam_title = '',
        minimizedQuestion = {},
        typeList = {},
    } = {}) => ({
        teacher_id,
        exam_id,
        exam_title,
        minimizedQuestion,
        typeList,
        csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '',

        quillEditors: {},
        editorReady: false,
        tempQuestionCounter: 0,

        //Question CRUD
        questions,
        dirtyQuestions: [],
        dirtyOptions: [],
        deletedQuestions: [],
        newQuestions: [],
        updatedQuestions: [],

        //Autosave Properties
        autoSavePoll: null,
        saving: false,
        saveStatus: 'idle',
        lastSavedAt: null,
        autoSaveDelay: 30000,
        titleUpdatedHandler: null,

        init() {

            //Mapping minimized state for every question
            this.questions = this.questions.map((question) => this.normalizeQuestion(question))

            this.minimizedQuestion = Object.fromEntries(
                this.questions.map((question) => [question.id, false])
            )

            //Trigger Quill Editor
            this.$nextTick(() => {
                this.editorReady = true
            })

            this.startAutoSavePoll()


            //This to mirror title from sibling livewire component
            this.titleUpdatedHandler = (event) => {
                this.exam_title = event.detail.title
            }

            window.addEventListener('exam-title-updated', this.titleUpdatedHandler)

        },
        destroy() {
            this.stopAutoSavePoll()

            if (this.titleUpdatedHandler) {
                window.removeEventListener('exam-title-updated', this.titleUpdatedHandler)
                this.titleUpdatedHandler = null
            }
        },


        //Make sure question has similiar structure
        normalizeQuestion(question) {
            return {
                ...question,
                question: question.question ?? '',
                question_delta: question.question_delta ?? null,
                is_rich_text: question.is_rich_text ?? false,
                options: Array.isArray(question.options) ? question.options : [],
            }

        },

        //Quill Editor Handler
        initQuillEditors(element, questionId, index) {
            if (this.quillEditors[questionId]) return
            if (typeof window.Quill === 'undefined' || typeof window.katex === 'undefined') {
                setTimeout(() => this.initQuillEditors(element, questionId, index), 50)
                return
            }

            const quill = new window.Quill(element, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ script: 'sub' }, { script: 'super' }],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['link', 'formula', 'clean'],
                    ],
                },
            })

            const question = this.questions.find((item) => item.id === questionId)

            if (question?.question_delta?.ops) {
                quill.setContents(question.question_delta)
            } else {
                quill.root.innerHTML = question?.question ?? ''
            }

            quill.on('text-change', () => {
                const targetQuestion = this.questions.find((item) => item.id === questionId)

                if (!targetQuestion) {
                    return
                }

                targetQuestion.question = quill.root.innerHTML
                targetQuestion.question_delta = quill.getContents()

                this.markDirtyQuestions(questionId)

            })

            this.quillEditors[questionId] = quill
        },

        //Question Preview. Need to improve for the rich text
        getRawQuestionPreview(questionHtml) {
            if (!questionHtml) {
                return 'Soal kosong...'
            }

            const temp = document.createElement('div')
            temp.innerHTML = questionHtml

            const preview = (temp.textContent || temp.innerText || '')
                .replace(/\s+/g, ' ')
                .trim()

            return preview || 'Soal kosong...'
        },

        //Minimize State Handler
        toggleMinimizeQuestion(question_id) {
            this.minimizedQuestion[question_id] = !this.minimizedQuestion[question_id]
        },

        markDirtyQuestions(questionId) {
            if (this.dirtyQuestions.includes(questionId)) {
                return
            }

            this.dirtyQuestions.push(questionId)
        },

        logQuestionType(questionId, value) {
            this.markDirtyQuestions(questionId)
        },

        logQuestionWeight(questionId, value) {
            this.markDirtyQuestions(questionId)
        },

        logQuestionRefAnswer(questionId, value) {
            this.markDirtyQuestions(questionId)
        },

        markDirtyOptions(optionId) {

            if (this.dirtyOptions.includes(optionId)) {
                return
            }

            this.dirtyOptions.push(optionId)
        },

        logOptionChange(questionId, optionId, value) {
            this.markDirtyOptions(optionId)
            this.markDirtyQuestions(questionId)
        },

        addDeletedQuestion(questionId = null, index = null) {
            if (questionId != null && this.deletedQuestions.includes(questionId)) {
                return
            }

            if (!String(questionId).startsWith('temp-')) {
                this.deletedQuestions.push(questionId)
            }

            this.questions.splice(index, 1)
            delete this.minimizedQuestion[questionId]
            delete this.quillEditors[questionId]
        },

        createEmptyQuestion() {


            this.tempQuestionCounter += 1

            return {
                id: `temp-question-${this.tempQuestionCounter}`,
                exam_id: this.exam_id,
                teacher_id: this.teacher_id,
                options: [
                    { id: `temp-option-${this.tempQuestionCounter}-1`, label: 1, option: '' },
                    { id: `temp-option-${this.tempQuestionCounter}-2`, label: 2, option: '' },
                    { id: `temp-option-${this.tempQuestionCounter}-3`, label: 3, option: '' },
                    { id: `temp-option-${this.tempQuestionCounter}-4`, label: 4, option: '' },
                ],
                question: '',
                question_delta: null,
                is_rich_text: false,
                ref_answer: '',
                type: 'multiple_choice',
                weight: 1,
                is_new: true,
            }
        },

        addQuestion() {
            const newQuestion = this.createEmptyQuestion()
            this.questions.push(newQuestion)
            this.minimizedQuestion[newQuestion.id] = false
        },

        pushDirtyQuestion(question) {
            if (this.dirtyQuestions.includes(question.id)) {
                this.updatedQuestions.push(question)
            }
        },

        reconcileCreatedQuestions(createdQuestions = []) {
            createdQuestions.forEach(({ temp_id, question }) => {
                const index = this.questions.findIndex((item) => item.id === temp_id)

                if (index === -1) {
                    return
                }

                const normalizedQuestion = this.normalizeQuestion(question)

                this.questions[index] = normalizedQuestion
                this.minimizedQuestion[normalizedQuestion.id] = this.minimizedQuestion[temp_id] ?? false

                delete this.quillEditors[temp_id]
                delete this.minimizedQuestion[temp_id]

                this.dirtyQuestions = this.dirtyQuestions.filter((id) => id !== temp_id)
                this.deletedQuestions = this.deletedQuestions.filter((id) => id !== temp_id)
            })
        },


        async autoSave() {
            if (!this.autoSavePermit()) {
                return
            }

            this.saving = true
            this.saveStatus = 'saving'

            this.newQuestions = []
            this.updatedQuestions = []

            this.questions.forEach(question => {
                if (String(question.id).startsWith('temp-')) {
                    this.newQuestions.push(question)
                } else {
                    this.pushDirtyQuestion(question)
                }
            });

            try {
                const response = await fetch('/teacher/exams/autosave',
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            Accept: 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken,
                        },
                        body: JSON.stringify({
                            exam_id: this.exam_id,
                            teacher_id: this.teacher_id,
                            new_questions: this.newQuestions,
                            updated_questions: this.updatedQuestions,
                            deleted_questions: this.deletedQuestions
                        })
                    }

                )

                if (!response.ok) {
                    throw new Error('Autosave failed: ', response.status)
                }

                const payload = await response.json()

                if (payload.status == 'success') {
                    this.reconcileCreatedQuestions(payload.created_questions ?? [])
                    this.dirtyQuestions = []
                    this.newQuestions = []
                    this.updatedQuestions = [],
                    this.deletedQuestions = [],
                    this.lastSavedAt = new Date().toLocaleTimeString()
                    this.saveStatus = 'saved'
                }

            } catch (error) {
                this.saveStatus = 'error'
            } finally {
                this.saving = false
            }
        },

        autoSavePermit(){
            if (
                this.dirtyQuestions.length <= 0 &&
                this.deletedQuestions.length <= 0
            ) {
                return false
            }

            if (this.saveStatus == 'saving') {
                return false
            }

            return true
        },

        startAutoSavePoll(){
            this.stopAutoSavePoll()

            this.autoSavePoll = setTimeout(async () => {
                if (!this.saving) {
                    await this.autoSave()
                }

                this.startAutoSavePoll()
            }, this.autoSaveDelay)
        },

        stopAutoSavePoll(){
            if (this.autoSavePoll) {
                clearTimeout(this.autoSavePoll)
                this.autoSavePoll = null
            }
        }
    }))
})
