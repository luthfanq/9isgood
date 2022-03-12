<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Stock\StockOpname;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class StockOpnameTable extends DataTableComponent
{

    public $jenis;
    protected string $pageName = 'stockOpname';
    protected string $tableName = 'stockOpnameList';
    use DatatablesTraits;

    
    public function mount($jenis = null)
    {
        $this->jenis = $jenis;
    }

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

    public function query(): Builder
    {
        $stockMasuk = StockOpname::query()
        ->with(['gudang', 'pegawai', 'users'])
        ->where('active_cash', session('ClosedCash'))
        ->latest('kode');

        if ($this->jenis){
        return $stockMasuk->where('jenis', $this->kondisi);
        }

        return $stockMasuk;
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.stock_opname_table';
    }
}
