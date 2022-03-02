<x-atoms.table.td align="center" width="10%">
    {{$row->kode_lokal}}
</x-atoms.table.td>
<x-atoms.table.td width="30%">
    {{$row->nama}}
</x-atoms.table.td>
<x-atoms.table.td width="45%">
    {{$row->keterangan}}
</x-atoms.table.td>
<x-atoms.table.td align="center" width="15%">
    <x-atoms.button.btn-icon onclick="Livewire.emit('edit', {{$row->id}})">
        <i class="bi bi-check2-square fs-3"></i>
    </x-atoms.button.btn-icon>
    <x-atoms.button.btn-icon color="danger" onclick="Livewire.emit('destroy', {{$row->id}})">
        <i class="bi bi-trash-fill fs-3"></i>
    </x-atoms.button.btn-icon>
</x-atoms.table.td>
