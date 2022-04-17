<div>
    @if(session()->has('message'))
        <x-molecules.alert-danger>
            <span>{{session('message')}}</span>
        </x-molecules.alert-danger>
    @endif
    <div class="d-flex flex-column flex-lg-row">
        <!-- begin:table cards-->
        <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
            <x-molecules.card title="Form Piutang Penjualan">
                <div class="row">
                    <div class="col-6 mb-5">
                        <x-atoms.input.group-horizontal data-bs-toggle="modal" data-bs-target="#customer_modal" label="Customer" name="customer_id">
                            <x-atoms.input.text wire:model.defer="customer_nama"/>
                        </x-atoms.input.group-horizontal>
                    </div>
                    <div class="col-6 mb-5">
                        <x-atoms.input.group-horizontal label="Tgl Jurnal" name="tgl_jurnal">
                            <x-atoms.input.singledaterange wire:model.defer="tgl_jurnal" id="tglJurnal"/>
                        </x-atoms.input.group-horizontal>
                    </div>
                    <div class="col-6 mb-5">
                        <x-atoms.input.group-horizontal label="Keterangan" name="keterangan">
                            <x-atoms.input.text wire:model.defer="keterangan" />
                        </x-atoms.input.group-horizontal>
                    </div>
                    <div class="col-6 mb-5" class="text-end">
                        <x-atoms.button.btn-modal target="#penjualan_modal">Add Nota</x-atoms.button.btn-modal>
                        <x-atoms.button.btn-danger wire:click="store">Simpan</x-atoms.button.btn-danger>
                    </div>
                </div>

                <x-atoms.table class="mt-6">
                    <x-slot name="head">
                        <tr>
                            <x-atoms.table.td width="5%">ID</x-atoms.table.td>
                            <x-atoms.table.td>Penjualan</x-atoms.table.td>
                            <x-atoms.table.td>PPN</x-atoms.table.td>
                            <x-atoms.table.td>Biaya Lain</x-atoms.table.td>
                            <x-atoms.table.td>Total Bayar</x-atoms.table.td>
                            <x-atoms.table.td width="10%"></x-atoms.table.td>
                        </tr>
                    </x-slot>
                    @forelse($data_detail as $index=>$row)
                        <tr>
                            <x-atoms.table.td>{{$loop->iteration}}</x-atoms.table.td>
                            <x-atoms.table.td>
                                {{$row['penjualan_kode']}}
                            </x-atoms.table.td>
                            <x-atoms.table.td align="end">
                                {{$row['penjualan_ppn'] ? rupiah_format($row['penjualan_ppn']) : 0}}
                            </x-atoms.table.td>
                            <x-atoms.table.td align="end">
                                {{$row['penjualan_biaya_lain'] ? rupiah_format($row['penjualan_biaya_lain']) : 0}}
                            </x-atoms.table.td>
                            <x-atoms.table.td align="end">
                                {{rupiah_format($row['penjualan_total_bayar'])}}
                            </x-atoms.table.td>
                            <x-atoms.table.td>
                                <x-atoms.button.btn-icon wire:click="destroyLine({{$index}})"><i class="la la-trash fs-2"></i></x-atoms.button.btn-icon>
                            </x-atoms.table.td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak Ada Data</td>
                        </tr>
                    @endforelse
                </x-atoms.table>

            </x-molecules.card>
        </div>
        <!-- end:table cards-->
    </div>

    <!-- begin:modal-penjualan -->
    <x-molecules.modal size="xl" title="Daftar Penjualan Periode Lalu" id="penjualan_modal" wire:ignore.self>
        <livewire:datatables.keuangan.penjualan-set-piutang-table />
    </x-molecules.modal>
    <!-- end:modal-penjualan -->

    <!-- begin:modal-customer -->
    <x-molecules.modal size="xl" title="Daftar Customer" id="customer_modal" wire:ignore.self>
        <livewire:datatables.customer-set-table />
    </x-molecules.modal>
    <!-- end:modal-customer -->

    @push('custom-scripts')
        <script>
            let penjualan_modal = new bootstrap.Modal(document.getElementById('penjualan_modal'));

            Livewire.on('setPenjualan', function (){
                penjualan_modal.hide();
            })

            let customer_modal = new bootstrap.Modal(document.getElementById('customer_modal'));

            Livewire.on('set_customer', function (){
                customer_modal.hide();
            })

            $('#tglJurnal').on('change', function (e) {
                let date = $(this).data("#tgl_nota");
                // eval(date).set('tglLahir', $('#tglLahir').val())
                console.log(e.target.value);
                @this.tgl_jurnal = e.target.value;
            })
        </script>
    @endpush

</div>
