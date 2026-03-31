function registerExamAttempt() {
    window.Alpine.data('examAttempt', ({
        questions = [],
        answers = {},
        exam_taker_id = null,
        exam_taker_status = '',
        student_id = null,
        duration = 0,
        startAt = null,
    } = {}) => ({
        questions,
        answers,
        exam_taker_id,
        exam_taker_status,
        student_id,
        csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '',

        // Timer state
        duration: Number(duration) || 0,
        startAt,
        timeleft: 0,
        timerPoll: null,

        // Question and answer state
        currentIndex: 0,
        questionViewer: null,
        savePoll: null,
        isDirtyIndex: [],
        showQuestionList: true,

        // Submitting state
        submit_form: false,
        submit_type: '',
        submit_status: '',
        redirect_time: 5,
        redirectPoll: null,

        init() {

            console.log(this.questions);


            if (this.exam_taker_status == 'finished') {
                this.submit_type = 'success'
            }

            this.$watch('answers', () => {
                if (!this.isDirtyIndex.includes(this.currentIndex)) {
                    this.isDirtyIndex.push(this.currentIndex)
                }
            })

            this.savePoll = setInterval(() => {
                this.autoSave()
            }, 30000)

            this.timeleft = this.getRemainingSeconds()

            this.timerPoll = setInterval(() => {
                this.timeleft = this.getRemainingSeconds()

                if (this.timeleft === 0 && this.timerPoll) {
                    clearInterval(this.timerPoll)
                    this.timerPoll = null
                    this.submit_form = true
                    this.submit_type = 'times_up'
                }
            }, 1000)
        },

        destroy() {
            if (this.savePoll) {
                clearInterval(this.savePoll)
            }

            if (this.timerPoll) {
                clearInterval(this.timerPoll)
            }

            if (this.redirectPoll) {
                clearInterval(this.redirectPoll)
            }
        },

        initQuestionViewer(element) {
            if (this.questionViewer) {
                return
            }

            if (typeof window.Quill === 'undefined' || typeof window.katex === 'undefined') {
                setTimeout(() => this.initQuestionViewer(element), 50)
                return
            }

            this.questionViewer = new window.Quill(element, {
                theme: 'snow',
                readOnly: true,
                modules: {
                    toolbar: false,
                },
            })

            this.questionViewer.disable()
            this.renderCurrentQuestion()
        },

        renderCurrentQuestion() {
            if (!this.questionViewer) {
                return
            }

            if (!this.currentQuestion) {
                this.questionViewer.setText('')
                return
            }

            if (this.currentQuestion.is_rich_text && this.currentQuestion.question_delta?.ops) {
                this.questionViewer.setContents(this.currentQuestion.question_delta)
                return
            }

            this.questionViewer.setText('')
            this.questionViewer.root.innerHTML = this.currentQuestion.question ?? ''
        },

        get currentQuestion() {
            return this.questions[this.currentIndex] ?? null
        },

        get currentAnswer() {
            if (!this.currentQuestion) {
                return null
            }

            if (!this.answers[this.currentQuestion.id]) {
                this.answers[this.currentQuestion.id] = {
                    question_id: this.currentQuestion.id,
                    answer: null,
                    marked: false,
                }
            }

            return this.answers[this.currentQuestion.id]
        },

        nextQuestion() {
            if (this.currentIndex < this.questions.length - 1) {
                this.currentIndex += 1
            }
        },

        prevQuestion() {
            if (this.currentIndex > 0) {
                this.currentIndex -= 1
            }
        },

        markQuestion() {
            if (!this.currentAnswer) {
                return
            }

            this.currentAnswer.marked = !this.currentAnswer.marked
        },
        toggleQuestionList(){
            this.showQuestionList = !this.showQuestionList


        }
        ,

        getRemainingSeconds() {
            if (this.submit_status == 'submitting') {
                return this.timeleft
            }

            if (!this.startAt || !this.duration) {
                return 0
            }

            const startAtSeconds = new Date(this.startAt).getTime()

            if (Number.isNaN(startAtSeconds)) {
                return 0
            }

            const elapsedSeconds = Math.floor((Date.now() - startAtSeconds) / 1000)
            const remainingSeconds = (this.duration * 60) - elapsedSeconds

            return Math.max(remainingSeconds, 0)
        },

        get remainingHours() {
            return String(Math.floor(this.timeleft / 3600)).padStart(2, '0')
        },

        get remainingMinutes() {
            return String(Math.floor((this.timeleft % 3600) / 60)).padStart(2, '0')
        },

        get remainingSeconds() {
            return String(this.timeleft % 60).padStart(2, '0')
        },

        async autoSave() {


            if (this.isDirtyIndex.length === 0 || this.submit_status == 'submitting') {
                return
            }

            const changedAnswers = this.isDirtyIndex
                .map((index) => this.questions[index]?.id)
                .map((questionId) => this.answers[questionId])
                .filter(Boolean)
                .map((answer) => ({
                    ...answer,
                    answer: answer.answer == null ? null : String(answer.answer),
                }))

            if (changedAnswers.length === 0) {
                return
            }

            try {
                const response = await fetch('/student/exams/exam-attempt/autosave', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                    },
                    body: JSON.stringify({
                        exam_taker_id: this.exam_taker_id,
                        student_id: this.student_id,
                        answers: changedAnswers,
                    }),
                })

                if (!response.ok) {
                    throw new Error(`Autosave failed: ${response.status}`)
                }

                const result = await response.json()

                if (result.status === 'success') {
                    this.isDirtyIndex = []
                }
            } catch (error) {
                console.log('Auto Save Failed', error)
            }
        },

        async submit(redirectUrl = null) {
            if (this.submit_status == 'submitting') {
                return
            }

            this.submit_type = 'submitting'
            this.submit_status = 'submitting'
            this.redirect_time = 5
            await this.autoSave()

            try {
                const submitresponse = await fetch('/student/exams/exam-attempt/submit',
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            Accept: 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken,
                        },
                        body: JSON.stringify({
                            exam_taker_id: this.exam_taker_id,
                            student_id: this.student_id,
                            status: 'finished',
                        }),
                    }
                )

                if (!submitresponse.ok) {
                    throw new Error(`Submit failed: ${submitresponse.status}`)
                }

                const result = await submitresponse.json()

                if (result.status == 'success') {
                    this.submit_type = 'success'
                    this.submit_status = ''

                    if (redirectUrl) {
                        if (this.redirectPoll) {
                            clearInterval(this.redirectPoll)
                        }

                        this.redirectPoll = setInterval(() => {
                            this.redirect_time -= 1

                            if (this.redirect_time <= 0) {
                                clearInterval(this.redirectPoll)
                                this.redirectPoll = null
                                window.location.href = redirectUrl
                            }
                        }, 1000)
                    }
                } else {
                    this.submit_type = 'failed'
                    this.submit_status = ''
                }
            } catch (error) {
                this.submit_type = 'failed'
                this.submit_status = ''
                console.log('Submit Failed', error)
            }
        }
    }))
}

if (window.Alpine) {
    registerExamAttempt()
} else {
    document.addEventListener('alpine:init', registerExamAttempt)
}
