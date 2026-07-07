<div x-data="{
        show: false,
        message: '',
        type: 'success',
        timeoutId: null,

        triggerToast(event) {
            const detail = event.detail || {};
            const payload = Array.isArray(detail) ? (detail[0] || {}) : detail;

            this.message = payload.message || '';
            this.type = payload.type || 'success';
            this.show = true;

            clearTimeout(this.timeoutId);
            this.timeoutId = setTimeout(() => {
                this.show = false;
            }, 4000);
        }
    }"
    x-on:show-toast.window="triggerToast($event)"
    x-show="show"
    x-cloak
    style="display: none;"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:translate-x-6"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:translate-x-6"
    class="fixed bottom-6 right-6 z-[100] w-full max-w-sm"
>
    <div class="relative flex items-center gap-3 rounded-xl bg-white p-4 shadow-lg ring-1 ring-black/5"
         :class="{
            'shadow-success-500/10 ring-success-500/20': type === 'success',
            'shadow-warning-500/10 ring-warning-500/20': type === 'warning',
            'shadow-danger-500/10 ring-danger-500/20': type === 'failed',
            'shadow-secondary-500/10 ring-secondary-500/20': !['success', 'warning', 'failed'].includes(type)
         }">

        <div class="shrink-0">
            <template x-if="type === 'success'">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-success-50 text-success-500">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
            </template>

            <template x-if="type === 'warning'">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-warning-50 text-warning-500">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                </div>
            </template>

            <template x-if="type === 'failed'">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-danger-50 text-danger-500">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                    </svg>
                </div>
            </template>

            <template x-if="!['success', 'warning', 'failed'].includes(type)">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-secondary-50 text-secondary-500">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                    </svg>
                </div>
            </template>
        </div>

        <div class="flex-1">
            <p class="text-sm font-semibold text-gray-900"
               x-text="type === 'success' ? 'Berhasil' : (type === 'warning' ? 'Perhatian' : (type === 'failed' ? 'Gagal' : 'Informasi'))">
            </p>
            <p class="text-sm text-gray-500" x-text="message"></p>
        </div>

        <div class="shrink-0">
            <button x-on:click="show = false; clearTimeout(timeoutId)" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-secondary-500 focus:ring-offset-2">
                <span class="sr-only">Close</span>
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                </svg>
            </button>
        </div>
    </div>
</div>
