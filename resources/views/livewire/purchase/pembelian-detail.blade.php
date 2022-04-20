<div>
    <x-molecules.modal title="Nomor Nota : {{isset($pembelian_data) ? $pembelian_data->kode : ''}}" size="xl" id="penjualan-detail" wire:ignore.self>
        <form>
            <div class="row">
                <div class="col-6">
                    <x-atoms.input.group-horizontal label="Customer">
                        <x-atoms.input.plaintext>{{$pembelian_data->supplier->nama ?? ''}}</x-atoms.input.plaintext>
                    </x-atoms.input.group-horizontal>
                </div>
                <div class="col-6">
                    <x-atoms.input.group-horizontal label="Jenis">
                        <x-atoms.input.plaintext>{{$pembelian_data->jenis_bayar ?? ''}}</x-atoms.input.plaintext>
                    </x-atoms.input.group-horizontal>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <x-atoms.input.group-horizontal label="Tgl Nota">
                        <x-atoms.input.plaintext>{{ isset($pembelian_data->tgl_nota) ? tanggalan_format($pembelian_data->tgl_nota) : ''}}</x-atoms.input.plaintext>
                    </x-atoms.input.group-horizontal>
                </div>
                <div class="col-6">
                    <x-atoms.input.group-horizontal label="Tgl Tempo">
                        <x-atoms.input.plaintext>{{isset($pembelian_data->tgl_tempo) ? tanggalan_format($pembelian_data->tgl_tempo) : ''}}</x-atoms.input.plaintext>
                    </x-atoms.input.group-horizontal>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <x-atoms.input.group-horizontal label="Gudang">
                        <x-atoms.input.plaintext>{{ $pembelian_data->gudang->nama ?? ''}}</x-atoms.input.plaintext>
                    </x-atoms.input.group-horizontal>
                </div>
                <div class="col-6">
                    <x-atoms.input.group-horizontal label="Keterangan">
                        <x-atoms.input.plaintext>{{ $pembelian_data->keterangan ?? ''  }}</x-atoms.input.plaintext>
                    </x-atoms.input.group-horizontal>
                </div>
            </div>
        </form>
        <x-atoms.table>
            <x-slot name="head">
                <tr>
                    <th>Kode</th>
                    <th>Item</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Diskon</th>
                    <th>Sub Total</th>
                </tr>
            </x-slot>
            @isset($pembelian_detail_data)
                @foreach($pembelian_detail_data as $item)
                    <tr>
                        <x-atoms.table.td align="center">
                            {{$item->kode_lokal}}
                        </x-atoms.table.td>
                        <x-atoms.table.td>
                            {{$item->produk->nama}}
                        </x-atoms.table.td>
                        <x-atoms.table.td align="right">
                            {{$item->harga}}
                        </x-atoms.table.td>
                        <x-atoms.table.td align="center">
                            {{$item->jumlah}}
                        </x-atoms.table.td>
                        <x-atoms.table.td align="center">
                            {{$item->diskon}}
                        </x-atoms.table.td>
                        <x-atoms.table.td align="end">
                            {{rupiah_format($item->sub_total)}}
                        </x-atoms.table.td>
                    </tr>
                @endforeach
            @endisset
            <x-slot name="footer">
                <tr>
                    <td colspan="4"></td>
                    <td>Total</td>
                    <td class="text-end">
                        @isset($pembelian_detail_data)
                            {{ rupiah_format($pembelian_detail_data->sum('sub_total')) }}
                        @endisset
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td>Biaya Lain</td>
                    <td class="text-end">
                        {{isset($pembelian_data->biaya_lain) ? rupiah_format($pembelian_data->biaya_lain) : 0 }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td>PPN</td>
                    <td class="text-end">
                        {{isset($pembelian_data->ppn) ? rupiah_format($pembelian_data->ppn) : 0 }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td>Total Bayar</td>
                    <td class="text-end">
                        {{isset($pembelian_data->total_bayar) ? rupiah_format($pembelian_data->total_bayar) : 0 }}
                    </td>
                </tr>
            </x-slot>
        </x-atoms.table>
        <x-slot name="footer"></x-slot>
    </x-molecules.modal>

    @push('custom-scripts')
        <script>
            let modal_penjualan_detail = document.getElementById('penjualan-detail');
            let modalPenjualanDetail = new bootstrap.Modal(modal_penjualan_detail);

            Livewire.on('show', function (){
                modalPenjualanDetail.show()
            })

            Livewire.on('showPembelianDetail', function (){
                modalPenjualanDetail.show()
            })
        </script>
    @endpush
</div>
