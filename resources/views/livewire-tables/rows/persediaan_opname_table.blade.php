<x-atoms.table.td>
    {{$row->kode}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->kondisi}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->gudang->nama}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->users->name}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->keterangan}}
</x-atoms.table.td>
<x-atoms.table.td>
    <x-atoms.button.btn-icon-link :href="route('persediaan.opname.trans', $row->id)" color="info"><i class="far fa-edit"></i></x-atoms.button.btn-icon-link>
    <x-atoms.button.btn-icon color="danger"><i class="fas fa-trash"></i></x-atoms.button.btn-icon>
</x-atoms.table.td>
