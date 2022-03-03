<x-atoms.table.td width="10%" align="center">
    {{$loop->iteration}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->nama}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->alamat}}
    {{$row->kota}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->keterangan}}
</x-atoms.table.td>
<x-atoms.table.td width="10%" align="center">
    <x-atoms.button.btn-icon onclick="Livewire.emit('edit', {{$row->id}})">
        <i class="bi bi-check2-square fs-3"></i>
    </x-atoms.button.btn-icon>
    <x-atoms.button.btn-icon color="danger" onclick="Livewire.emit('destroy', {{$row->id}})">
        <i class="bi bi-trash-fill fs-3"></i>
    </x-atoms.button.btn-icon>
</x-atoms.table.td>
