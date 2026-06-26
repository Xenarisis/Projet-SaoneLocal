<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Notification extends Component {
    public string $type;
    public string $title;
    public string $description;

    /**
     * Create a new component instance.
     */
    public function __construct(string $title, string $description, string $type = 'success') {
        $this->title = $title;
        $this->description = $description;
        $this->type = $type;
    }

    public function color(): string {
        return match ($this->type) {
            'info'    => 'bg-blue-500 dark:bg-blue-400',
            'error'   => 'bg-red-500 dark:bg-red-400',
            'warning' => 'bg-amber-500 dark:bg-amber-400',
            default   => 'bg-green-500 dark:bg-green-400',
        };
    }

    public function icon(): string {
        return match ($this->type) {
            'info'    => 'images/info-notif.svg',
            'error'   => 'images/error-notif.svg',
            'warning' => 'images/warn-notif.svg',
            default   => 'images/check-notif.svg',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string {
        return view('components.notification');
    }
}