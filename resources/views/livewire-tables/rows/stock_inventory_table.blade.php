<x-atoms.table.td align="center">
    {{$row->produk->kode_lokal}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->produk->nama}} <br>
    {{$row->cover}} {{$row->produk->kategoriHarga->nama}}
</x-atoms.table.td>
<x-atoms.table.td align="center">
    {{ucfirst($row->jenis)}}
</x-atoms.table.td>
<x-atoms.table.td align="center">
    {{ucfirst($row->gudang->nama)}}
</x-atoms.table.td>
<x-atoms.table.td align="end">
    {{rupiah_format($row->stock_opname)}}
</x-atoms.table.td>
<x-atoms.table.td align="end">
    {{rupiah_format($row->stock_masuk)}}
</x-atoms.table.td>
<x-atoms.table.td align="end">
    {{rupiah_format($row->stock_keluar)}}
</x-atoms.table.td>
<x-atoms.table.td align="end">
    {{rupiah_format($row->stock_opname + $row->stock_masuk - $row->stock_keluar)}}
</x-atoms.table.td>
