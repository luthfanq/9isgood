<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Stock\StockAkhir;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class StockAkhirTable extends DataTableComponent
{
    use DatatablesTraits;

    protected $listeners = [
        'refreshDatatable'=>'$refresh',
        'setLastSession'
    ];

    public function columns(): array
    {
        return [
            Column::make('ID', 'kode')
                ->sortable()
                ->searchable()
                ->addClass('hidden md:table-cell')
                ->selected(),
            Column::make('Gudang', 'gudang.nama')
                ->sortable()
                ->searchable(),
            Column::make('Pegawai', 'pegawai.nama')
                ->sortable()
                ->searchable(),
            Column::make('Pembuat', 'users.nama')
                ->sortable()
                ->searchable(),
            Column::make('Tgl Input', 'tgl_input')
                ->sortable()
                ->searchable(),
            Column::make('Action', 'actions')
                ->sortable()
                ->searchable(),
        ];
    }

    public $lastSession;

    public function mount()
    {
        $this->lastSession = session('ClosedCash');
    }

    public function setLastSession($session)
    {
        $this->lastSession = $session;
    }

    public function query(): Builder
    {
        return StockAkhir::query()
            ->where('active_cash', $this->lastSession)
            ->latest('kode');
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.stock_akhir_table';
    }
}
