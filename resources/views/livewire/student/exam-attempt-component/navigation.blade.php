<div class="flex justify-between">
    <!-- Previous -->
    <button
        wire:click="navigate({{$currentIndex - 1}})"
        @disabled($currentIndex == 0)
        @class([
            'py-1 px-5 text-secondary-400 hover:underline',
            'text-slate-400' => $currentIndex == 0,
        ])
    >
        <div class="flex gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-arrow-big-left-dash-icon lucide-arrow-big-left-dash pt-1">
                <path
                    d="M13 9a1 1 0 0 1-1-1V5.061a1 1 0 0 0-1.811-.75l-6.835 6.836a1.207 1.207 0 0 0 0 1.707l6.835 6.835a1 1 0 0 0 1.811-.75V16a1 1 0 0 1 1-1h2a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1z" />
                <path d="M20 9v6" />
            </svg>
            <p>Previous</p>
        </div>
    </button>

    <!-- Next -->
    <button
        wire:click="navigate({{$currentIndex + 1}})"
        @disabled($currentIndex == $lastQuestion - 1)
        @class([
            'py-1 px-5 text-secondary-400 hover:underline',
            'text-slate-400' => $currentIndex == $lastQuestion - 1,
        ])
    >
        <div class="flex gap-1">
            <p>Next</p>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-arrow-big-right-dash-icon lucide-arrow-big-right-dash pt-1">
                <path
                    d="M11 9a1 1 0 0 0 1-1V5.061a1 1 0 0 1 1.811-.75l6.836 6.836a1.207 1.207 0 0 1 0 1.707l-6.836 6.835a1 1 0 0 1-1.811-.75V16a1 1 0 0 0-1-1H9a1 1 0 0 1-1-1v-4a1 1 0 0 1 1-1z" />
                <path d="M4 9v6" />
            </svg>
        </div>
    </button>
</div>
