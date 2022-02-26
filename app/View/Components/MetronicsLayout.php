<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MetronicsLayout extends Component
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('layouts.metronics');
    }
}
