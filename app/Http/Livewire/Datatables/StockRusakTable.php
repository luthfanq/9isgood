<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Stock\StockMutasi;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class StockRusakTable extends DataTableComponent
{
    use DatatablesTraits;

    public function columns(): array
    {
        return [
            Column::make('ID', 'kode'),
            Column::make('Tanggal'),
            Column::make('Gudang Asal'),
            Column::make('Gudang Tujuan'),
            Column::make('Pembuat'),
            Column::make('Keterangan'),
        ];
    }

    public function query(): Builder
    {
        return StockMutasi::query()
            ->where('jenis_mutasi', 'baik_rusak')
            ->where('active_cash', session('ClosedCash'));
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.stock_rusak_table';
    }
}
