<?php

namespace App\Http\Livewire\Datatables;

use App\Models\Keuangan\Akun;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AkunSetTable extends DataTableComponent
{

    public function columns(): array
    {
        return [
        Column::make('Kode', 'akun_kategori_id')
            ->searchable()
            ->sortable(),
        Column::make('Tipe', 'akun_tipe_id')
            ->searchable()
            ->sortable(),
        Column::make('Kode', 'kode'),
        Column::make('Deskripsi', 'deskripsi'),
        Column::make('Keterangan', 'keterangan'),
        Column::make('Action'),
        ];
    }

    public function query(): Builder
    {
        return Akun::query();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.akun_set_table';
    }
}
