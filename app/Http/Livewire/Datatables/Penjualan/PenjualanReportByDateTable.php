<?php

namespace App\Http\Livewire\Datatables\Penjualan;

use App\Haramain\Repository\Penjualan\PenjualanPureRepo;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PenjualanReportByDateTable extends DataTableComponent
{
    protected $listeners = [
        'refreshDatatables'=>'$refresh',
        'setTanggal'
    ];

    public bool $showSearch = false;

    public $tglAwal, $tglAkhir;

    public function columns(): array
    {
        return [
            Column::make('ID', 'kode')
                ->searchable()
                ->addClass('hidden md:table-cell')
                ->selected(),
            Column::make('Customer', 'customer.nama')
                ->searchable(),
            Column::make('Gudang', 'gudang.nama')
                ->searchable(),
            Column::make('Tgl Nota', 'tgl_nota')
                ->searchable(),
            Column::make('Tgl Tempo', 'tgl_tempo')
                ->searchable(),
            Column::make('Status Bayar', 'status_bayar')
                ->searchable(),
            Column::make('Total Bayar', 'total_bayar')
                ->searchable(),
        ];
    }

    public function setTanggal($tglAwal, $tglAkhir)
    {
        $this->tglAwal = $tglAwal;
        $this->tglAkhir = $tglAkhir;
    }

    public function query(): Builder
    {
        return (new PenjualanPureRepo())->getByDate($this->tglAwal, $this->tglAkhir);
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.penjualan_report_by_date_table';
    }
}
