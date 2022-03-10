<?php

namespace App\Http\Livewire\Datatables\Keuangan;

use App\Models\Keuangan\AkunKategori;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AkunKategoriTable extends DataTableComponent
{

    public function columns(): array
    {
        return [
            Column::make('Kode'),
            Column::make('Tipe'),
            Column::make('Keterangan'),
            Column::make(''),
        ];
    }

    public function query(): Builder
    {
        return AkunKategori::query()->latest();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.akun_kategori_table';
    }
}
