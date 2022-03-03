<div>
    <x-molecules.modal title="Data Detail" size="lg" id="penjualan-detail" wire:ignore.self>
        <form>
            <div class="row">
                <div class="col-6">
                    <x-atoms.input.group-horizontal label="Customer">
                        <x-atoms.input.plaintext>{{$penjualan_data->customer->nama ?? ''}}</x-atoms.input.plaintext>
                    </x-atoms.input.group-horizontal>
                </div>
                <div class="col-6">
                    <x-atoms.input.group-horizontal label="Jenis">
                        <x-atoms.input.plaintext>{{$penjualan_data->jenis_bayar ?? ''}}</x-atoms.input.plaintext>
                    </x-atoms.input.group-horizontal>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <x-atoms.input.group-horizontal label="Tgl Nota">
                        <x-atoms.input.plaintext>{{ isset($penjualan_data->tgl_nota) ? tanggalan_format($penjualan_data->tgl_nota) : ''}}</x-atoms.input.plaintext>
                    </x-atoms.input.group-horizontal>
                </div>
                <div class="col-6">
                    <x-atoms.input.group-horizontal label="Tgl Tempo">
                        <x-atoms.input.plaintext>{{isset($penjualan_data->tgl_tempo) ? tanggalan_format($penjualan_data->tgl_tempo) : ''}}</x-atoms.input.plaintext>
                    </x-atoms.input.group-horizontal>
                </div>
            </div>
        </form>
    </x-molecules.modal>

    @push('custom-scripts')
        <script>
            let modal_penjualan_detail = document.getElementById('penjualan-detail');
            let modalPenjualanDetail = new bootstrap.Modal(modal_penjualan_detail);

            Livewire.on('hidePenjualanDetail', function (){
                modalPenjualanDetail.hide()
            })

            Livewire.on('showPenjualanDetail', function (){
                modalPenjualanDetail.show()
            })
        </script>
    @endpush
</div>
