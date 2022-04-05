<?php

namespace App\Http\Livewire;

use App\Haramain\Repository\Generator\ClosedCashRepository;
use App\Models\ClosedCash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class CloseCashIndex extends Component
{
    protected $listeners= [
        'refresh'=>'$refresh'
    ];
    public function render()
    {
        return view('livewire.close-cash-index',[
            'data_forView'=>ClosedCash::query()->get()
        ]);
    }

    public $closed_cash_data;

    public function mount()
    {
        $this->closed_cash_data = ClosedCash::query()->get();
    }

    public function store()
    {
        $ClosedCash = new ClosedCashRepository();
        \DB::beginTransaction();
        try {
            $ended = md5(now());
            $updated = ClosedCash::query()->where('active', session('ClosedCash'))->update(['closed'=>$ended]);
            $closed = ClosedCash::query()->create([
                'active'=>$ended,
                'closed'=>null,
                'user_id'=>\Auth::id()
            ]);
            session()->forget('ClosedCash');
            session(['ClosedCash'=>$closed->active]);
            $ClosedCash->generateStockOpname($ended);
            \DB::commit();
            $this->emit('store');
        } catch (ModelNotFoundException $e){
            \DB::rollBack();
        }
    }
}
