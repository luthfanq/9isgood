<?php

namespace App\Http\Livewire\Datatables\Keuangan;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Keuangan\PiutangPenjualanLama;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PenjualanLamaTable extends DataTableComponent
{
    use DatatablesTraits;
    public function columns(): array
    {
        return [
            Column::make('Nomor'),
            Column::make('Customer', 'customer.nama'),
            Column::make('Total Piutang'),
            Column::make(''),
        ];
    }

    public function query(): Builder
    {
        return PiutangPenjualanLama::query();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.penjualan_lama_table';
    }
}
