<x-atoms.table.td>
    {{$row->kode}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->tgl_jurnal}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->customer->nama}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->users->name}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->keterangan}}
</x-atoms.table.td>
<x-atoms.table.td>
    <x-atoms.button.btn-icon-link :href="route('penjualan.piutang.trans.piutangId', $row->id)" color="info"><i class="far fa-edit"></i></x-atoms.button.btn-icon-link>
    <x-atoms.button.btn-icon color="danger"><i class="fas fa-trash"></i></x-atoms.button.btn-icon>
</x-atoms.table.td>
