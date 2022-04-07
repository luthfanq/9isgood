<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Purchase\PembelianRetur;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PembelianReturTable extends DataTableComponent
{
    use DatatablesTraits;

    public $kondisi;

    public function mount($kondisi = 'baik')
    {
        $this->kondisi = $kondisi;
    }

    public function columns(): array
    {
        return [

            Column::make('ID', 'kode')
                ->searchable()
                ->addClass('hidden md:table-cell')
                ->selected(),
            Column::make('Supplier', 'supplier.nama')
                ->searchable(),
            Column::make('Tgl Nota', 'tgl_nota')
                ->searchable(),
            Column::make('Tgl Tempo', 'tgl_tempo')
                ->searchable(),
            Column::make('Jenis Bayar', 'jenis_bayar')
                ->searchable(),
            Column::make('Status Bayar', 'status_bayar')
                ->searchable(),
            Column::make('Total Bayar', 'total_bayar')
                ->searchable(),
            Column::make(''),
        ];
    }

    public function query(): Builder
    {
        return PembelianRetur::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('kondisi', $this->kondisi)
            ->latest('kode');
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.pembelian_retur_table';
    }
}
