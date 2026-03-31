<div x-show="modalform" x-cloak class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-black/50 p-4"
    x-on:keyup.escape.window="modalform = false">

    <div class="my-auto max-h-[calc(100vh-2rem)] w-full max-w-5xl overflow-y-auto rounded-lg bg-white p-6 shadow-lg"
        x-on:click.outside="modalform = false">
        <div class="flex justify-between items-center mb-4">

            <h2 class="text-lg font-semibold mb-2">
                {{ $formName }}
            </h2>


            <button type="button" @click="modalform = false"
                class="text-gray-400 hover:text-gray-600 text-2xl leading-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-x-icon lucide-x">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>

        {{ $slot }}

    </div>
</div>
