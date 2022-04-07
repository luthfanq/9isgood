<?php

namespace App\Http\Livewire\Keuangan\Jurnal;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Keuangan\JurnalUmum;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class JurnalUmumTable extends DataTableComponent
{
    use DatatablesTraits;

    public function columns(): array
    {
        return [
            Column::make('Kode'),
            Column::make('Tanggal'),
            Column::make(''),
            Column::make('Pembuat'),
            Column::make('Keterangan'),
        ];
    }

    public function query(): Builder
    {
        return JurnalUmum::query()
            ->where('active_cash', session('ClosedCash'));
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.jurnal_umum_table';
    }
}
