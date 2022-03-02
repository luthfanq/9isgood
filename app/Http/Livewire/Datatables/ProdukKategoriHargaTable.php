<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Master\ProdukKategoriHarga;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ProdukKategoriHargaTable extends DataTableComponent
{
    use DatatablesTraits;

    public function columns(): array
    {
        return [
            Column::make('Nama')
                ->searchable(),
            Column::make('Keterangan')
                ->searchable(),
            Column::make(''),
        ];
    }

    public function query(): Builder
    {
        return ProdukKategoriHarga::query();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.produk_kategori_harga_table';
    }
}
