<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Keuangan\JurnalPiutangPegawai;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PenerimaanPiutangInternalTable extends DataTableComponent
{
    use DatatablesTraits;


    public function columns(): array
    {
        return [
            Column::make('ID', 'kode')
            ->searchable()
            ->addClass('hidden md:table-cell')
            ->selected(),
        Column::make('Pegawai', 'pegawai.nama')
            ->searchable(),
        Column::make('Pembuat', 'user.nama')
            ->searchable(),
        Column::make('Status', 'status')
            ->searchable(),
        Column::make('Tanggal', 'tgl_piutang')
            ->searchable(),
        Column::make('Nominal', 'nominal')
            ->searchable(),
        Column::make('Keterangan', 'keterangan')
            ->searchable(),
        Column::make(''),
        ];
    }

    public function query(): Builder
    {
        return JurnalPiutangPegawai::query()
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.penerimaan_piutang_internal_table';
    }
}
