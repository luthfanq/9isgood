<x-atoms.table.td>
    {{$row->DT_RowIndex}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->akun_id->deskripsi}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->debet}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->kredit}}
</x-atoms.table.td>
<x-atoms.table.td>
    <x-atoms.button.btn-icon onclick="Livewire.emit('edit', {{$row->id}})">
        <i class="bi bi-check2-square fs-3"></i>
    </x-atoms.button.btn-icon>
    <x-atoms.button.btn-icon color="danger" onclick="Livewire.emit('destroy', {{$row->id}})">
        <i class="bi bi-trash-fill fs-3"></i>
    </x-atoms.button.btn-icon>
</x-atoms.table.td>
