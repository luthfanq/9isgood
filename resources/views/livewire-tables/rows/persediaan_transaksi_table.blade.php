<x-atoms.table.td align="center">
    {{$row->kode}}
</x-atoms.table.td>
<x-atoms.table.td align="center">
    @if($row->persediaan_type == 'App\Models\Purchase\Pembelian')
        Pembelian
    @elseif($row->stockable_masuk_type == 'App\Models\Stock\StockMutasi')
        Mutasi Stock
    @endif
</x-atoms.table.td>
<x-atoms.table.td align="center">
    {{$row->persediaanable_transaksi->kode}}
</x-atoms.table.td>
<x-atoms.table.td align="center">
    {{$row->persediaanable_transaksi->supplier->nama}}
</x-atoms.table.td>
<x-atoms.table.td align="end">
    {{$row->debet}}
</x-atoms.table.td>
<x-atoms.table.td align="end">
    {{$row->kredit}}
</x-atoms.table.td>
