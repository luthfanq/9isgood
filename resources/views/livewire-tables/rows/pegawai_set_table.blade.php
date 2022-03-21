<x-atoms.table.td width="10%">
    {{$row->kode}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{ucwords($row->nama)}}
</x-atoms.table.td>
<x-atoms.table.td>
    {{$row->alamat ? ucwords($row->alamat) : ''}} <br>
    {{$row->telepon}}
</x-atoms.table.td>
<x-atoms.table.td width="15%" align="center">
    <x-atoms.button.btn-icon onclick="Livewire.emit('set_pegawai', {{$row->id}})">
        set
    </x-atoms.button.btn-icon>
</x-atoms.table.td>
