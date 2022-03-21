<x-atoms.table.td align="center">
    {{$row->kode}}
</x-atoms.table.td>
<x-atoms.table.td align="center">
    {{ucwords($row->gudang->nama)}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->pegawai->nama ?? ''}}
</x-atoms.table.td>
<x-atoms.table.td align="center">
    {{ucwords($row->users->name)}}
</x-atoms.table.td>
<x-atoms.table.td align="center">
    {{tanggalan_format($row->tgl_input)}}
</x-atoms.table.td>
<x-atoms.table.td align="center" width="12%">
    <x-atoms.button.btn-icon-link :href="url('/').'/stock/stockakhir/transaksi/'.$row->id"><i class="far fa-edit fs-4"></i></x-atoms.button.btn-icon-link>
    <x-atoms.button.btn-icon color="danger" onclick="Livewire.emit('destroy', {{$row->id}})"><i class="bi bi-trash-fill fs-4"></i></x-atoms.button.btn-icon>
    <x-atoms.button.btn-icon><i class="fas fa-indent fs-4" onclick="Livewire.emit('showStockDetail', {{$row->id}})"></i></x-atoms.button.btn-icon>
    <x-atoms.button.btn-icon-link color="info"><i class="fas fa-print fs-4"></i></x-atoms.button.btn-icon-link>
</x-atoms.table.td>
