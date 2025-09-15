<div x-show="modal" style="display: none"
    class="inset-0 z-50 fixed flex justify-center align-middle bg-black/10 backdrop-brightness-50">
    <x-card x-on:click.outside="modal = !modal"
        class="max-w-md w-full absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
        <p class=" font-semibold text-xl mb-4 text-center">{{ $message }}</p>
        <div class=" flex gap-2">
            {{$slot}}
            <x-submit-button type="button" class=" bg-white !text-black border border-secondary-400 hover:bg-gray-400 hover:border-gray-400" x-on:click="modal = !modal">Tidak</x-submit-button>
        </div>
    </x-card>
</div>
