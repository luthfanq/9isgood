<?php

namespace App\Http\Livewire\Keuangan;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Keuangan\PersediaanAwalTemporary;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PersediaanAwalTempTable extends DataTableComponent
{
    use DatatablesTraits;

    protected string $pageName = 'persediaanawal';

    public function columns(): array
    {
        return [
            Column::make('ID'),
            Column::make('Kondisi'),
            Column::make('Gudang'),
            Column::make('Produk'),
            Column::make('Jumlah'),
            Column::make(''),
        ];
    }

    public function query(): Builder
    {
        return PersediaanAwalTemporary::query()
            ->leftJoin('produk', 'haramain_keuangan.persediaan_awal_temporary.produk_id', '=', 'produk.id')
            ->where('active_cash', session('ClosedCash'))
            ->oldest('produk.nama');
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.persediaan_awal_temp_table';
    }
}
