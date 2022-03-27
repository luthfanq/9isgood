<?php

namespace App\Http\Livewire\Datatables\Keuangan;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Keuangan\PersediaanTransaksi;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PersediaanTransaksiTable extends DataTableComponent
{
    use DatatablesTraits;
    public function columns(): array
    {
        return [
            Column::make('ID', 'kode'),
            Column::make('Jenis'),
            Column::make('Kode'),
            Column::make('Supplier / Customer'),
            Column::make('Debet'),
            Column::make('Kredit'),
        ];
    }

    public function query(): Builder
    {
        return PersediaanTransaksi::query();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.persediaan_transaksi_table';
    }
}
