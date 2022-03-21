<x-atoms.table.td width="10%">
    {{$row->kode}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{ucwords($row->nama)}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->alamat ? ucwords($row->alamat) : ''}} <br>
    {{$row->telepon}}
</x-atoms.table.td>
<x-atoms.table.td width="15%" align="center">
    <x-atoms.button.btn-icon onclick="Livewire.emit('edit', {{$row->id}})">
        <i class="bi bi-check2-square fs-3"></i>
    </x-atoms.button.btn-icon>
    <x-atoms.button.btn-icon color="danger" onclick="Livewire.emit('destroy', {{$row->id}})">
        <i class="bi bi-trash-fill fs-3"></i>
    </x-atoms.button.btn-icon>
</x-atoms.table.td>
