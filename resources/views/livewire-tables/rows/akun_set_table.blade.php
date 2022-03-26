<x-atoms.table.td width="10%" align="center">
    {{$row->akun_kategori_id}}
</x-atoms.table.td>
<x-atoms.table.td width="20%">
    {{$row->akun_tipe_id}}
</x-atoms.table.td>
<x-atoms.table.td width="10%" align="center">
    {{$row->kode}}
</x-atoms.table.td>
<x-atoms.table.td width="15%">
    {{$row->deskripsi}}
</x-atoms.table.td>
<x-atoms.table.td width="30%">
    {{$row->keterangan}}
</x-atoms.table.td>
<x-atoms.table.td width="15%" align="center">
    <x-atoms.button.btn-icon onclick="Livewire.emit('set_akun', {{$row->id}})">
        set
    </x-atoms.button.btn-icon>
</x-atoms.table.td>
