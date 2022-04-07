<x-atoms.table.td>
    {{$row->kode}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{tanggalan_format($row->tgl_jurnal)}}
</x-atoms.table.td>
<x-atoms.table.td>
    @if($row->is_persediaan_awal == true)
        Neraca Saldo Awal
    @endif
</x-atoms.table.td>
<x-atoms.table.td>
    {{ucwords($row->users->name)}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->keterangan}}
</x-atoms.table.td>
<x-atoms.table.td align="center">
    @if($row->is_persediaan_awal == false)
        <x-atoms.button.btn-icon color="danger"><i class="fas fa-trash"></i></x-atoms.button.btn-icon>
    @endif
    <x-atoms.button.btn-icon color="dark" onclick="Livewire.emit('showPenjualanDetail', {{$row->id}})"><i class="fas fa-indent"></i></x-atoms.button.btn-icon>
    <x-atoms.button.btn-icon-link href="penjualan/print/{{$row->id}}" color="info"><i class="fas fa-print"></i></x-atoms.button.btn-icon-link>

</x-atoms.table.td>
