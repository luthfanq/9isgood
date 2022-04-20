<?php

namespace App\Http\Livewire\Pembelian;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Purchase\Pembelian;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PembelianInternalTable extends DataTableComponent
{
    use DatatablesTraits;
    public function columns(): array
    {
        return [
            Column::make('ID'),
            Column::make('Supplier'),
            Column::make('Gudang'),
            Column::make('Tgl Nota'),
            Column::make('Surat Jalan'),
            Column::make('Pembuat'),
            Column::make('Keterangan'),
            Column::make(''),
        ];
    }

    public function query(): Builder
    {
        return Pembelian::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('jenis', 'INTERNAL');
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.pembelian_internal_table';
    }
}
