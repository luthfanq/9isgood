<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Stock\StockMutasi;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class StockMutasiTable extends DataTableComponent
{
    public $jenis_mutasi;
    protected string $pageName = 'stockMutasi';
    protected string $tableName = 'stockMutasiList';

    
    public function mount($jenis_mutasi = null)
    {
        $this->jenis_mutasi = $jenis_mutasi;
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'kode')
                ->sortable()
                ->searchable()
                ->addClass('hidden md:table-cell')
                ->selected(),
            Column::make('Gudang Asal', 'gudangAsal.nama')
                ->sortable()
                ->searchable(),
            Column::make('Gudang Tujuan', 'gudangTujuan.nama')
                ->sortable()
                ->searchable(),
            Column::make('Pembuat', 'users.nama')
                ->sortable()
                ->searchable(),
            Column::make('Tgl Mutasi', 'tgl_mutasi')
                ->sortable()
                ->searchable(),
            Column::make('Action', 'actions')
                ->sortable()
                ->searchable(),      
            ];
    }

    public function query(): Builder
    {
        $stockMutasi = StockMutasi::query()
            ->with(['gudangAsal', 'gudangTujuan', 'users'])
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');

        if ($this->jenis_mutasi){
            return $stockMutasi->where('jenis_mutasi', $this->jenis_mutasi);
        }

        return $stockMutasi;
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.stock_mutasi_table';
    }
}
