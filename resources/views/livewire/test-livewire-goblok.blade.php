<div>
    <div class=" mt-4 bg-secondary-400">
        Test
    </div>
    <x-form-input wire:model.live="message"></x-form-input>
    <div>
        {{ $message }}
    </div>



    <div wire:click="counter">
        <x-submit-button wire:click="counter">
            Counter
        </x-submit-button>
    </div>

    <div wire:click="request">
        Test Event
    </div>

    <div wire:click="incrementCounter">
        Counter Div
    </div>


    @dump($counter)
</div>
