<div x-show="toast" style="display: none"
    x-data="{
        timeoutId: null,
        restartTimer() {
            clearTimeout(this.timeoutId);
            this.timeoutId = setTimeout(() => {
                toast = false;
            }, 4500);
        }
    }"
    x-init="$watch('toast', value => {
        if (value) {
            restartTimer();
        } else {
            clearTimeout(timeoutId);
        }
    })"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="translate-y-3 opacity-0"
    x-transition:enter-end="translate-y-0 opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="translate-y-0 opacity-100"
    x-transition:leave-end="translate-y-2 opacity-0">
    <div class="fixed bottom-8 right-6 z-[60] w-[min(28rem,calc(100vw-2rem))] overflow-hidden rounded-2xl border bg-white/95 shadow-[0_18px_45px_rgba(15,23,42,0.18)] backdrop-blur"
        :class="{
            'border-l-8 border-l-success-500 border-success-200': type === 'success',
            'border-l-8 border-l-warning-500 border-warning-200': type === 'warning',
            'border-l-8 border-l-danger-500 border-danger-500': type === 'failed',
            'border-l-8 border-l-secondary-400 border-secondary-200': !['success', 'warning', 'failed'].includes(type),
        }">
        <div class="flex items-start gap-4 px-5 py-4">
            <div class="mt-1 shrink-0">
                <template x-if="type === 'success'">
                    <div class="rounded-full bg-success-100 p-2 text-success-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                            <path d="m9 11 3 3L22 4" />
                        </svg>
                    </div>
                </template>

                <template x-if="type === 'warning'">
                    <div class="rounded-full bg-warning-100 p-2 text-warning-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3" />
                            <path d="M12 9v4" />
                            <path d="M12 17h.01" />
                        </svg>
                    </div>
                </template>

                <template x-if="type === 'failed'">
                    <div class="rounded-full bg-danger-100 p-2 text-danger-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="m15 9-6 6" />
                            <path d="m9 9 6 6" />
                        </svg>
                    </div>
                </template>

                <template x-if="!['success', 'warning', 'failed'].includes(type)">
                    <div class="rounded-full bg-secondary-100 p-2 text-secondary-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 8v4" />
                            <path d="M12 16h.01" />
                        </svg>
                    </div>
                </template>
            </div>

            <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold"
                    :class="{
                        'text-success-800': type === 'success',
                        'text-warning-800': type === 'warning',
                        'text-danger-800': type === 'failed',
                        'text-secondary-600': !['success', 'warning', 'failed'].includes(type),
                    }"
                    x-text="type === 'success' ? 'Berhasil' : (type === 'warning' ? 'Perhatian' : (type === 'failed' ? 'Gagal' : 'Informasi'))">
                </p>
                <p class="mt-1 text-sm leading-6 text-slate-600" x-text="message">{{ $slot }}</p>
            </div>

            <button type="button" class="mt-1 shrink-0 rounded-full p-1 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600"
                @click="toast = false; clearTimeout(timeoutId)">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>
