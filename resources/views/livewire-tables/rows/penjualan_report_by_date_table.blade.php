<x-atoms.table.td align="center">
    {{$row->kode}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->customer->nama}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->gudang->nama}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{tanggalan_format($row->tgl_nota)}}
</x-atoms.table.td>
<x-atoms.table.td>
    @if($row->jenis_bayar == 'tempo'||'Tempo')
        {{tanggalan_format($row->tgl_tempo)}}
    @endif
</x-atoms.table.td>
<x-atoms.table.td align="center">
    {{$row->status_bayar}}
</x-atoms.table.td>
<x-atoms.table.td align="end">
    {{rupiah_format($row->total_bayar)}}
</x-atoms.table.td>
