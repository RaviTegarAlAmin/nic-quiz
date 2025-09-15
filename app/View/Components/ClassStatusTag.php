<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ClassStatusTag extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $status = 'not_started',
        public ?string $message = '',
        public ?bool $label = false
    ) {
        if ($label == true) {
            switch ($status) {
                case 'not_started':
                    $this->message = 'Belum Mulai';
                    break;

                case 'finished':
                    $this->message = 'Selesai';
                    break;

                case 'on_hold':
                    $this->message = 'Ditunda';
                    break;

                case 'published':
                    $this->message = 'Published';
                    break;

                case 'ongoing':
                    $this->message = 'Berjalan';
                    break;


                default:
                    $this->message = 'Status Salah';
                    break;
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.class-status-tag');
    }
}
