<?php

namespace App\Http\Livewire;

use App\Models\ClosedCash;
use Livewire\Component;

class CloseCashIndex extends Component
{
    public function render()
    {
        return view('livewire.close-cash-index');
    }

    public $closed_cash_data;

    public function mount()
    {
        $this->closed_cash_data = ClosedCash::query()->get();
        //dd(session('ClosedCash'));
    }

    public function store()
    {
        $ended = md5(now());
        $updated = ClosedCash::query()->where('active', session('ClosedCash'))->update(['closed'=>$ended]);
        $closed = ClosedCash::query()->create([
            'active'=>$ended,
            'closed'=>null,
            'user_id'=>\Auth::id()
        ]);
        session()->forget('ClosedCash');
        session(['ClosedCash'=>$closed->active]);
    }
}
