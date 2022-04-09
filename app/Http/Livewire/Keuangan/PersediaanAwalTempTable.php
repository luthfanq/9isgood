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
    public $kondisi = 'baik';
    public $gudang_id = 1;

    protected $listeners = [
        'refreshDatatable'=>'$refresh',
        'setGudang'
    ];

    public function setGudang($gudang_id)
    {
        $this->gudang_id = $gudang_id;
    }

    public function columns(): array
    {
        return [
            Column::make('ID'),
            Column::make('Kondisi'),
            Column::make('Gudang'),
            Column::make('Produk', 'produk.nama')
                ->searchable(),
            Column::make('Jumlah'),
            Column::make(''),
        ];
    }

    public function query(): Builder
    {
        return PersediaanAwalTemporary::query()->with('produk', 'produk.kategoriHarga')
            ->where('kondisi', $this->kondisi)
            ->where('gudang_id', $this->gudang_id)
            ->where('jumlah', '>', 0)
            ->oldest('produk_id');
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.persediaan_awal_temp_table';
    }
}
