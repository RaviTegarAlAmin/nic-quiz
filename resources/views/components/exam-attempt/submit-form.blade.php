<div>
    <template x-if="submit_form">
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
            <div class="w-full max-w-xl rounded-xl bg-white p-6 shadow-xl">
                <template x-if="submit_type === 'times_up'">
                    <div>
                        @include('components.exam-attempt.submit.times-up')
                    </div>
                </template>

                <template x-if="submit_type === 'manual'">
                    <div>
                         @include('components.exam-attempt.submit.manual-trigger')
                    </div>
                </template>

                <template x-if="submit_type === 'success'">
                    <div>
                        @include('components.exam-attempt.submit.success')
                    </div>
                </template>

                <template x-if="submit_type === 'failed'">
                    <div>
                        @include('components.exam-attempt.submit.failed')
                    </div>
                </template>

                <template x-if="submit_type === 'submitting'">
                    <div>
                        @include('components.exam-attempt.submit.submitting')
                    </div>
                </template>
            </div>
        </div>
    </template>

</div>
