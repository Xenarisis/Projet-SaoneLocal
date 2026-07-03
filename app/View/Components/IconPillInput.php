<?php

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class IconPillInput extends Component {
    public $icon;
    public $asterisk;
    public $textId;

    public function __construct($icon = null, $asterisk = false) {
        $this->icon = $icon;
        $this->asterisk = $asterisk;
        $this->textId = 'file-text-' . Str::random(8);
    }

    public function getSvgIcon() {
        if (!$this->icon) {
            return null;
        }

        $path = public_path($this->icon);
        $isSvg = str_ends_with(strtolower($this->icon), '.svg');

        return ($isSvg && file_exists($path)) ? file_get_contents($path) : null;
    }

    public function getAsteriskSvg() {
        $path = public_path('images/asterisk.svg');
        
        if (file_exists($path)) {
            return file_get_contents($path);
        }

        return null;
    }

    public function render()
    {
        return view('components.form.icon-pill-input');
    }
}