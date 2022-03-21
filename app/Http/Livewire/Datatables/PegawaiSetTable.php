<?php

namespace App\Http\Livewire\Datatables;

use App\Models\Master\Pegawai;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PegawaiSetTable extends DataTableComponent
{

    public function columns(): array
    {
        return [
            Column::make('Column Name'),
        ];
    }

    public function query(): Builder
    {
        return Pegawai::query()
            ->latest();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.pegawai_set_table';
    }
}
