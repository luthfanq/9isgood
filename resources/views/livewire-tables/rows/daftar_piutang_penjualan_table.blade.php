<x-atoms.table.td>
    {{$row->customer->nama}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{($row->tgl_awal) ? tanggalan_format($row->tgl_awal) : ''}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{($row->tgl_akhir) ? tanggalan_format($row->tgl_akhir) : ''}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{rupiah_format($row->saldo)}}
</x-atoms.table.td>
