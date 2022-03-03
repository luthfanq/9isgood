<x-atoms.table.td width="10%" align="center">
    {{$row->kode}}
</x-atoms.table.td>
<x-atoms.table.td width="10%" align="center">
    {{$row->kode_lokal}}
</x-atoms.table.td>
<x-atoms.table.td width="25%">
    {{$row->nama}}<br>
    {{$row->kategori->nama}}
    {{$row->kategoriHarga->nama}}
</x-atoms.table.td>
<x-atoms.table.td width="15%" align="end">
    {{rupiah_format($row->harga)}}
</x-atoms.table.td>
<x-atoms.table.td width="10%" align="center">
    {{$row->cover}}
</x-atoms.table.td>
<x-atoms.table.td width="10%">
    {{$row->penerbit}}
</x-atoms.table.td>
<x-atoms.table.td width="10%" align="center">
    <x-atoms.button.btn-icon onclick="Livewire.emit('edit', {{$row->id}})">
        <i class="bi bi-check2-square fs-3"></i>
    </x-atoms.button.btn-icon>
    <x-atoms.button.btn-icon color="danger" onclick="Livewire.emit('destroy', {{$row->id}})">
        <i class="bi bi-trash-fill fs-3"></i>
    </x-atoms.button.btn-icon>
</x-atoms.table.td>
