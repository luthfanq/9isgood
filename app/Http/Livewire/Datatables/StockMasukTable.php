<?php

namespace App\Http\Livewire\Datatables;

use App\Haramain\Traits\LivewireTraits\DatatablesTraits;
use App\Models\Stock\StockMasuk;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class StockMasukTable extends DataTableComponent
{

    public $kondisi;
    protected string $pageName = 'stockMasuk';
    protected string $tableName = 'stockMasukList';
    use DatatablesTraits;

    public function mount($kondisi = null)
    {
        $this->kondisi = $kondisi;
    }
    public function columns(): array
    {
        return [
            Column::make('ID', 'kode')
                ->sortable()
                ->searchable()
                ->addClass('hidden md:table-cell')
                ->selected(),
                Column::make('Jenis')
                    ->sortable()
                    ->searchable(),
            Column::make('Gudang', 'gudang.nama')
                ->sortable()
                ->searchable(),
            Column::make('Nomor PO', 'nomor_po')
                ->sortable()
                ->searchable(),
            Column::make('Supplier', 'supplier.nama')
                ->sortable()
                ->searchable(),
            Column::make('Pembuat', 'users.nama')
                ->sortable()
                ->searchable(),
            Column::make('Tgl Masuk', 'tgl_masuk')
                ->sortable()
                ->searchable(),
            Column::make('Action', 'actions')
                ->sortable()
                ->searchable(),
        ];
    }

    public function query(): Builder
    {
        $stockMasuk = StockMasuk::query()
            ->with(['gudang', 'supplier', 'users'])
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');

        if ($this->kondisi){
            return $stockMasuk->where('kondisi', $this->kondisi);
        }

        return $stockMasuk;
    }


    public function edit($id)
    {
        return redirect()->to('stock/masuk/baik/edit/'.$id);
    }

    public function editRusak($id)
    {
        return redirect()->to('stock/masuk/rusak/edit/'.$id);
    }

    public function print($id)
    {
        return redirect()->to(''.$id);
    }


    public function rowView(): string
    {
        return 'livewire-tables.rows.stock_masuk_table';
    }
}
