<div x-show="modal" style="display: none"
    class="inset-0 z-50 fixed flex justify-center align-middle bg-black/10 backdrop-brightness-50">
    @if ($disabled)
        <x-card
            class="max-w-md w-full absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
            <p class=" font-semibold text-xl mb-4 text-center">{{ $message }}</p>
            <div class=" flex gap-2">
                {{ $slot }}
            </div>
        </x-card>
    @else
        <x-card x-on:click.outside="modal = !modal"
            class="max-w-md w-full absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
            <p class=" font-semibold text-xl mb-4 text-center">{{ $message }}</p>
            <div class=" flex gap-2">
                {{ $slot }}
                <button
                x-on:click="modal = !modal"
                class="bg-white font-semibold px-1 py-1 w-full border-2 border-transparent hover:border-secondary-500">
                Tidak
                </button>
            </div>
        </x-card>
    @endif
</div>
