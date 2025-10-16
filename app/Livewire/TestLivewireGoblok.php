<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class TestLivewireGoblok extends Component
{

    public int $counter = 0;
    public ?string $message = '';

    public function request(){
        $this->dispatch('test');
    }

    #[On('test')]
    public function incrementCounter(){
        $this->counter += 1;
    }

    public function changeText(string $newText){
        $this->message = $newText;
    }

    public function mount(string $message){
        $this->message = $message;
    }
    public function render()
    {
        return view('livewire.test-livewire-goblok');
    }
}
