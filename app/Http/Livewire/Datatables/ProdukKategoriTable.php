<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Master\ProdukKategori;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ProdukKategoriTable extends DataTableComponent
{
    use DatatablesTraits;

    public function columns(): array
    {
        return [
            Column::make('Kode', 'kode_lokal')
                ->searchable(),
            Column::make('Nama')
                ->searchable(),
            Column::make('Keterangan'),
        ];
    }

    public function query(): Builder
    {
        return ProdukKategori::query();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.produk_kategori_table';
    }
}
