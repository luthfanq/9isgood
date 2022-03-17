<x-atoms.table.td align="center">
    {{$row->kode}}
</x-atoms.table.td>
<x-atoms.table.td align="center">
    @if($row->stockable_keluar_type == 'App\Models\Penjualan\Penjualan')
        Penjualan
    @else
        Stock Keluar
    @endif
</x-atoms.table.td>
<x-atoms.table.td align="center">
    {{$row->gudang->nama}}
</x-atoms.table.td>
<x-atoms.table.td align="center">
    {{tanggalan_format($row->tgl_keluar)}}
</x-atoms.table.td>
<x-atoms.table.td align="center">
    {{$row->supplier->nama ?? ''}}
</x-atoms.table.td>
<x-atoms.table.td align="center">
    {{$row->stockable_keluar->customer->nama ?? ''}}
</x-atoms.table.td>
<x-atoms.table.td align="center">
    {{ucwords($row->users->name)}}
</x-atoms.table.td>
<x-atoms.table.td class="text-center" width="12%">
    @if($row->stockable_keluar_type == 'App\Models\Penjualan\Penjualan')

    @else
        <x-atoms.button.btn-icon-link :href="url('/').'/stock/transaksi/keluar/trans/'.$row->id"><i class="far fa-edit fs-4"></i></x-atoms.button.btn-icon-link>
        <x-atoms.button.btn-icon color="danger"><i class="bi bi-trash-fill fs-4"></i></x-atoms.button.btn-icon>
    @endif

    <x-atoms.button.btn-icon><i class="fas fa-indent fs-4" onclick="Livewire.emit('showStockDetail', {{$row->id}})"></i></x-atoms.button.btn-icon>
    <x-atoms.button.btn-icon-link color="info"><i class="fas fa-print fs-4"></i></x-atoms.button.btn-icon-link>

</x-atoms.table.td>
