<x-atoms.table.td>
    {{$row->kode}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->supplier->nama}}
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
    @if($row->status_bayar == 'belum')
        <x-atoms.button.btn-icon-link :href="route('pembelian.trans').'/'.$row->id" color="info"><i class="far fa-edit"></i></x-atoms.button.btn-icon-link>
        <x-atoms.button.btn-icon color="danger"><i class="fas fa-trash"></i></x-atoms.button.btn-icon>
    @endif
    <x-atoms.button.btn-icon color="dark" onclick="Livewire.emit('showPembelianDetail', {{$row->id}})"><i class="fas fa-indent"></i></x-atoms.button.btn-icon>
    <x-atoms.button.btn-icon color="info"><i class="fas fa-print"></i></x-atoms.button.btn-icon>
    <x-atoms.button.btn-icon color="success"><i class="fas fa-file-powerpoint"></i></x-atoms.button.btn-icon>
</x-atoms.table.td>
