<?php

namespace App\Http\Livewire;

use App\Models\Master\ProdukKategori;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ProdukKategoriTable extends DataTableComponent
{

    public function columns(): array
    {
        return [
            Column::make('Column Name'),
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
