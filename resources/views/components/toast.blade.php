<div x-show="toast" style="display: none" x-init="if (toast) setTimeout(() => toast = false, 5000)" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">
    <div
        class="flex justify-between align-middle py-1 px-2 border-1 border-slate-600 border-l-2 bg-slate-200 hover:bg-slate-200/50 fixed bottom-20 rounded-r-lg drop-shadow-lg cursor-pointer">
        <div class="flex mb-2 align-middle gap-1">
            <div>
                <template x-if="type == 'success'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="lucide lucide-circle-check-big-icon lucide-circle-check-big text-success-500 mt-2">
                        <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                        <path d="m9 11 3 3L22 4" />
                    </svg>
                </template>

                <template x-if="type == 'warning'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="lucide lucide-triangle-alert-icon lucide-triangle-alert text-warning-500 mt-2">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3" />
                        <path d="M12 9v4" />
                        <path d="M12 17h.01" />
                    </svg>
                </template>

                <template x-if="type == 'failed'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="lucide lucide-circle-x-icon lucide-circle-x text-danger-700 mt-2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="m15 9-6 6" />
                        <path d="m9 9 6 6" />
                    </svg>
                </template>
            </div>
            <label class="font-normal" x-text="message">{{ $slot }}</label>
        </div>
        <div class="ml-3" @click="toast = false">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-x-icon lucide-x text-slate-400 hover:text-slate-500 mt-1.5">
                <path d="M18 6 6 18" />
                <path d="m6 6 12 12" />
            </svg>
        </div>
    </div>
