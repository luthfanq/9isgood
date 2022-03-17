<?php

namespace App\Http\Livewire\Datatables;

use App\Models\Keuangan\KasirPenjualan;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PenerimaanPenjualanTable extends DataTableComponent
{

    public function columns(): array
    {
        return [
            Column::make('Column Name'),
        ];
    }

    public function query(): Builder
    {
        return KasirPenjualan::query();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.penerimaan_penjualan_table';
    }
}
