<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Master\Pegawai;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PegawaiTable extends DataTableComponent
{
    use DatatablesTraits;

    public function columns(): array
    {
        return [
            Column::make('Kode', 'id'),
            Column::make('Nama'),
            Column::make('Alamat'),
            Column::make(''),
        ];
    }

    public function query(): Builder
    {
        return Pegawai::query()
            ->latest();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.pegawai_table';
    }
}
