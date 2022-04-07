<x-atoms.table.td align="center" width="10%">
    {{$row->produk->kode_lokal}}
</x-atoms.table.td>
<x-atoms.table.td align="center" width="10%">
    {{ucwords($row->kondisi)}}
</x-atoms.table.td>
<x-atoms.table.td align="center" width="10%">
    {{ucwords($row->gudang->nama)}}
</x-atoms.table.td>
<x-atoms.table.td width="50%">
    {{$row->produk->nama}}<br>
    {{$row->produk->kategoriHarga->nama}} {{$row->produk->cover}}
</x-atoms.table.td>
<x-atoms.table.td align="center" width="10%">
    {{rupiah_format($row->jumlah)}}
</x-atoms.table.td>
<x-atoms.table.td width="10%">
    <x-atoms.button.btn-icon onclick="Livewire.emit('set_produk', {{$row->id}})">
        set
    </x-atoms.button.btn-icon>
</x-atoms.table.td>
