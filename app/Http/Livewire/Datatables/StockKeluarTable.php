<?php

namespace App\Http\Livewire\Datatables;

use App\Models\Stock\StockKeluar;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class StockKeluarTable extends DataTableComponent
{
    public $kondisi, $gudang;

    public function mount($kondisi = 'baik')
    {
        $this->kondisi = $kondisi;
    }

    public function columns(): array
    {
        return [
            Column::make('ID'),
            Column::make('Jenis'),
            Column::make('Gudang'),
            Column::make('Tgl_keluar'),
            Column::make('Supplier'),
            Column::make('Customer'),
            Column::make('Pembuat'),
            Column::make(''),
        ];
    }

    public function query(): Builder
    {
        $query = StockKeluar::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('kondisi', $this->kondisi)->latest('kode');

        if ($this->gudang)
        {
            return $query->where('gudang_id', $this->gudang);
        }

        return $query;
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.stock_keluar_table';
    }
}
