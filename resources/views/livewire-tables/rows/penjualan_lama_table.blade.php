<x-atoms.table.td width="10%">
    {{$loop->iteration}}
</x-atoms.table.td>
<x-atoms.table.td width="60%">
    {{$row->customer->nama}}
</x-atoms.table.td>
<x-atoms.table.td align="end" width="15%">
    {{rupiah_format($row->total_piutang)}}
</x-atoms.table.td>
<x-atoms.table.td width="15%">
    <x-atoms.button.btn-icon-link :href="route('penjualan.piutanglama.trans.piutangLamaId', $row->id)" color="info"><i class="far fa-edit"></i></x-atoms.button.btn-icon-link>
    <x-atoms.button.btn-icon color="dark" onclick="Livewire.emit('showPenjualanDetail', {{$row->id}})"><i class="fas fa-indent"></i></x-atoms.button.btn-icon>
    <x-atoms.button.btn-icon color="danger"><i class="fas fa-trash"></i></x-atoms.button.btn-icon>
</x-atoms.table.td>
