<?php

namespace App\Http\Livewire\Datatables\Keuangan;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Keuangan\Akun;
use App\Models\Keuangan\AkunKategori;
use App\Models\Keuangan\AkunTipe;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AkunTable extends DataTableComponent
{
    use DatatablesTraits;

    public bool $singleColumnSorting = true;

    public function columns(): array
    {
        return [
            Column::make('Kode', 'kode')
                ->sortable()
                ->searchable(),
            Column::make('Tipe', 'akunTipe.deskripsi')
                ->sortable(function(Builder $query, $direction) {
                    return $query->orderBy(AkunTipe::query()->select('deskripsi')->whereColumn('akun_tipe.id', 'akun.akun_tipe_id'), $direction);
                })
                ->searchable(),
            Column::make('Kategori')
                ->sortable(function(Builder $query, $direction) {
                    return $query->orderBy(AkunKategori::query()->select('deskripsi')->whereColumn('akun_kategori.id', 'akun.akun_kategori_id'), $direction);
                }),
            Column::make('Akun', 'deskripsi')
                ->sortable()
                ->searchable(),
            Column::make('Keterangan'),
            Column::make(''),
        ];
    }

    public function query(): Builder
    {
        return Akun::query();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.akun_table';
    }
}
