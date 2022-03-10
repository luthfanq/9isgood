<?php

namespace App\Http\Livewire\Datatables;

use App\Models\Stock\StockMasuk;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class StockMasukTable extends DataTableComponent
{
    public $kondisi, $gudang;

    public function mount($kondisi='baik', $gudang=null)
    {
        $this->kondisi = $kondisi;
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'kode'),
            Column::make('Jenis'),
            Column::make('Gudang'),
            Column::make('Nomor PO'),
            Column::make('Supplier'),
            Column::make('Pembuat'),
            Column::make('Tgl Masuk'),
            Column::make(''),
        ];
    }

    public function query(): Builder
    {
        $query = StockMasuk::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('kondisi', $this->kondisi);

        if ($this->gudang)
        {
            return $query->where('gudang_id', $this->gudang);
        }

        return $query;
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.stock_masuk_table';
    }
}
