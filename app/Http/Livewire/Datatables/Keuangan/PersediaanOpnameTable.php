<?php

namespace App\Http\Livewire\Datatables\Keuangan;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Keuangan\PersediaanOpname;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PersediaanOpnameTable extends DataTableComponent
{
    use DatatablesTraits;

    public function columns(): array
    {
        return [
            Column::make('ID'),
            Column::make('Kondisi'),
            Column::make('Gudang'),
            Column::make('Pembuat'),
            Column::make('Keterangan'),
            Column::make(''),
        ];
    }

    public function query(): Builder
    {
        return PersediaanOpname::query()
            ->where('active_cash', session('ClosedCash'));
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.persediaan_opname_table';
    }
}
