
<x-atoms.table.td>
    {{$row->config}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->akun->deskripsi}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->keterangan}}
</x-atoms.table.td>
<x-atoms.table.td>
    <x-atoms.button.btn-icon onclick="Livewire.emit('edit', '{{$row->config}}') ">
        <i class="bi bi-check2-square fs-3"></i>
    </x-atoms.button.btn-icon>
    <x-atoms.button.btn-icon color="danger" onclick="Livewire.emit('destroy', '{{$row->config}}' )">
        <i class="bi bi-trash-fill fs-3"></i>
    </x-atoms.button.btn-icon>
</x-atoms.table.td>
