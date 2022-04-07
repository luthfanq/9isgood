<?php

namespace App\Http\Livewire\Datatables\Keuangan;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Keuangan\PersediaanPerpetual;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PersediaanTable extends DataTableComponent
{
    use DatatablesTraits;
    public function columns(): array
    {
        return [
            Column::make('ID', 'produk.kode_lokal'),
            Column::make('Jenis'),
            Column::make('Kondisi'),
            Column::make('Gudang'),
            Column::make('Produk', 'produk.nama'),
            Column::make('Harga'),
            Column::make('Jumlah'),
            Column::make('Total'),
        ];
    }

    public function query(): Builder
    {
        return PersediaanPerpetual::query();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.persediaan_table';
    }
}
