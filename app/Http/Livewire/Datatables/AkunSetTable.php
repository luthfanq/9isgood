<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Keuangan\Akun;
use App\Models\Keuangan\AkunKategori;
use App\Models\Keuangan\AkunTipe;
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
            ->sortable(function(Builder $query, $direction) {
                return $query->orderBy(AkunKategori::query()->select('deskripsi')->whereColumn('akun_kategori.id', 'akun.akun_kategori_id'), $direction);
            })
            ->searchable(),
        Column::make('Tipe', 'akunTipe.deskripsi')
            ->sortable(function(Builder $query, $direction) {
                return $query->orderBy(AkunTipe::query()->select('deskripsi')->whereColumn('akun_tipe.id', 'akun.akun_tipe_id'), $direction);
            })
            ->searchable(),
        Column::make('Kode', 'kode')
            ->sortable()
            ->searchable(),
        Column::make('Deskripsi', 'deskripsi')
            ->sortable()
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
