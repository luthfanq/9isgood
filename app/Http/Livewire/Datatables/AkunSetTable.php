<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Keuangan\Akun;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AkunSetTable extends DataTableComponent
{
    use DatatablesTraits;

    public string $defaultSortColumn = 'kode';
    public string $defaultSortDirection = 'asc';

    public function columns(): array
    {
        return [
        Column::make('Kategori', 'akun_kategori_id')
            ->sortable()
            ->searchable(),
        Column::make('Tipe', 'akun_tipe_id'),
        Column::make('Kode', 'kode'),
        Column::make('Deskripsi', 'deskripsi')
            ->searchable(),
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
