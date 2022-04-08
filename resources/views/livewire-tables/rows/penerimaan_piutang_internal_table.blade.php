<x-atoms.table.td>
    {{$row->kode}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->pegawai->nama}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->user->nama}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->status}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{tanggalan_format($row->tgl_piutang)}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{rupiah_format($row->nominal)}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->keterangan}}
</x-atoms.table.td>
<x-atoms.table.td align="center">
        <x-atoms.button.btn-icon-link :href="url('/penjualan/retur/'.$row->jenis_retur.'/trans').'/'.$row->id" color="info"><i class="far fa-edit"></i></x-atoms.button.btn-icon-link>
        <x-atoms.button.btn-icon color="danger"><i class="fas fa-trash"></i></x-atoms.button.btn-icon>
        <x-atoms.button.btn-icon color="dark" onclick="Livewire.emit('showPenjualanDetail', {{$row->id}})"><i class="fas fa-indent"></i></x-atoms.button.btn-icon>
</x-atoms.table.td>
