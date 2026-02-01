<div
    x-show="modalform"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    @keydown.escape="open = false"
>
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">
                {{ $slot }}
            </h2>
            <button
                type="button"
                @click="modalform = false"
                class="text-gray-400 hover:text-gray-600 text-2xl leading-none"
            >
                &times;
            </button>
        </div>

        @include($formTarget)

    </div>
</div>
