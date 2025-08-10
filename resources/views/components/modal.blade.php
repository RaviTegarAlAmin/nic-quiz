<x-card class=" bg-white backdrop-blur-md fixed top-1/2 right-1/2 z-10">
    <div>
        {{ $slot }}
    </div>
    <div class=" flex">
        <x-submit-button class=" bg-warning-600">Ya</x-submit-button>
        <x-submit-button>Tidak</x-submit-button>
    </div>
</x-card>
