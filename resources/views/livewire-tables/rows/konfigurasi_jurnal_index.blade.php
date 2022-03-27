
<x-atoms.table.td width="10%" align="center">
    {{$row->config}}
</x-atoms.table.td>
<x-atoms.table.td width="10%" align="center">
    {{$row->akun->deskripsi}}

</x-atoms.table.td>
<x-atoms.table.td width="10%" align="center">
    {{$row->keterangan}}
</x-atoms.table.td>
<x-atoms.table.td width="10%" align="center">
    <x-atoms.button.btn-icon onclick="Livewire.emit('edit', '{{$row->config}}')">

        <i class="bi bi-check2-square fs-3"></i>
    </x-atoms.button.btn-icon>
    <x-atoms.button.btn-icon color="danger" onclick="Livewire.emit('destroy', '{{$row->config}}' )">
        <i class="bi bi-trash-fill fs-3"></i>
    </x-atoms.button.btn-icon>
</x-atoms.table.td>
