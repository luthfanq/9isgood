<div>
    <x-molecules.card>
        <x-atoms.table>
            <x-slot name="head">
                <tr>
                    <x-atoms.table.td>Tanggal</x-atoms.table.td>
                    <x-atoms.table.td>Kode</x-atoms.table.td>
                    <x-atoms.table.td>Keterangan</x-atoms.table.td>
                    <x-atoms.table.td>Stock Masuk</x-atoms.table.td>
                    <x-atoms.table.td>Stock Keluar</x-atoms.table.td>
                    <x-atoms.table.td></x-atoms.table.td>
                </tr>
            </x-slot>
            @php
                $jumlah = 0;
            @endphp
            @forelse($stockData as $item)
                <tr>
                    <x-atoms.table.td>
                        {{tanggalan_format($item->tanggal)}}
                    </x-atoms.table.td>
                    <x-atoms.table.td>
                        {{$item->kode}}
                    </x-atoms.table.td>
                    <x-atoms.table.td>
                        {{$item->nama}} ({{$item->nama_keterangan}})
                    </x-atoms.table.td>
                    <x-atoms.table.td align="end">
                        {{$item->stock_masuk}}
                    </x-atoms.table.td>
                    <x-atoms.table.td align="end">
                        {{$item->stock_keluar}}
                    </x-atoms.table.td>
                    <x-atoms.table.td align="end">
                        {{rupiah_format($jumlah += $item->stock_masuk - $item->stock_keluar)}}
                    </x-atoms.table.td>
                </tr>
            @empty
            @endforelse
        </x-atoms.table>
    </x-molecules.card>
</div>
