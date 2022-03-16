<?php

namespace App\Http\Livewire\Datatables;

use App\Models\Keuangan\SaldoPiutangPenjualan;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class DaftarPiutangPenjualanTable extends DataTableComponent
{

    public function columns(): array
    {
        return [
            Column::make('Customer'),
            Column::make('Tanggal Awal'),
            Column::make('Tanggal Akhir'),
            Column::make('Saldo'),
        ];
    }

    public function query(): Builder
    {
        return SaldoPiutangPenjualan::query();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.daftar_piutang_penjualan_table';
    }
}
