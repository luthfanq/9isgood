<x-atoms.table.td>
    {{$row->kode}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->customer->nama}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{tanggalan_format($row->tgl_nota)}}
</x-atoms.table.td>
<x-atoms.table.td>
    @if($row->tgl_tempo)
        {{tanggalan_format($row->tgl_tempo)}}
    @endif
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->jenis_bayar}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->status_bayar}}
</x-atoms.table.td>
<x-atoms.table.td align="end">
    {{rupiah_format($row->total_bayar)}}
</x-atoms.table.td>
<x-atoms.table.td align="center">
    <x-atoms.button.btn-icon color="dark" onclick="Livewire.emit('showPenjualanDetail', {{$row->id}})"><i class="fas fa-indent"></i></x-atoms.button.btn-icon>
    <x-atoms.button.btn-icon color="info" onclick="Livewire.emit('setPenjualan', {{$row->id}})"><i class="fas fa-pen"></i></x-atoms.button.btn-icon>
</x-atoms.table.td>
