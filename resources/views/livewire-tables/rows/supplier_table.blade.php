<x-atoms.table.td width="5%" align="center">
    {{$loop->iteration}}
</x-atoms.table.td>
<x-atoms.table.td width="15%" align="center">
    {{$row->jenisSupplier->jenis}}
</x-atoms.table.td>
<x-atoms.table.td width="20%">
    {{ucfirst($row->nama)}}
</x-atoms.table.td>
<x-atoms.table.td width="20%">
    {{$row->alamat}}
</x-atoms.table.td>
<x-atoms.table.td width="15%">
    {{$row->telepon}}
</x-atoms.table.td>
<x-atoms.table.td width="15%">
    {{$row->keterangan}} <br>
    {{$row->npwp}}
    {{$row->email}}
</x-atoms.table.td>
<x-atoms.table.td width="15%" align="center">
    <x-atoms.button.btn-icon onclick="Livewire.emit('edit', {{$row->id}})">
        <i class="bi bi-check2-square fs-3"></i>
    </x-atoms.button.btn-icon>
    <x-atoms.button.btn-icon color="danger" onclick="Livewire.emit('destroy', {{$row->id}})">
        <i class="bi bi-trash-fill fs-3"></i>
    </x-atoms.button.btn-icon>
</x-atoms.table.td>
