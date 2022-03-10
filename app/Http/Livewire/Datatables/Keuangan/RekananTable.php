<?php

namespace App\Http\Livewire\Datatables\Keuangan;

use App\Models\Keuangan\Rekanan;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class RekananTable extends DataTableComponent
{

    public function columns(): array
    {
        return [
            Column::make('ID', 'kode'),
            Column::make('Nama'),
            Column::make('Telepon'),
            Column::make('Alamat'),
            Column::make('Keterangan'),
            Column::make(''),
        ];
    }

    public function query(): Builder
    {
        return Rekanan::query()->latest();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.rekanan_table';
    }
}
