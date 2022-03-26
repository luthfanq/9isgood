<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\KonfigurasiJurnal;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class KonfigurasiJurnalIndex extends DataTableComponent
{
    use DatatablesTraits;

    public function columns(): array
    {
        return [        
            Column::make('Konfigurasi'),
            Column::make('Akun ID'),
            Column::make('Keterangan'),
            Column::make(''),

        ];
    }

    public function query(): Builder
    {
        return KonfigurasiJurnal::query()->latest();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.konfigurasi_jurnal_index';
    }
}
