<div>
    <div class="d-flex flex-column flex-lg-row">
        <!-- begin:card-->
        <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
            <x-molecules.card>
                <form>
                    <div class="row mb-6">
                        <div class="col-6">
                            <x-atoms.input.group-horizontal label="Customer" name="customer_id">
                                <x-atoms.input.text wire:model.defer="customer_nama" data-bs-toggle="modal" data-bs-target="#modal_customer" readonly />
                            </x-atoms.input.group-horizontal>
                        </div>
                        <div class="col-6">
                            <x-atoms.input.group-horizontal label="Tahun" name="tahun_nota">
                                <x-atoms.input.text wire:model.defer="tahun_nota" />
                            </x-atoms.input.group-horizontal>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <div class="col-6">
                            <x-atoms.input.group-horizontal label="Keterangan" name="keterangan">
                                <x-atoms.input.text wire:model.defer="keterangan" />
                            </x-atoms.input.group-horizontal>
                        </div>
                        <div class="col-6">
                            <x-atoms.input.group-horizontal label="Total Piutang" name="total_piutang">
                                <x-atoms.input.text wire:model.defer="total_piutang_rupiah" readonly/>
                            </x-atoms.input.group-horizontal>
                        </div>
                    </div>
                </form>
                <x-atoms.table>
                    <x-slot name="head">
                        <tr>
                            <x-atoms.table.td>ID</x-atoms.table.td>
                            <x-atoms.table.td>Tgl Nota</x-atoms.table.td>
                            <x-atoms.table.td>Total Bayar</x-atoms.table.td>
                            <x-atoms.table.td></x-atoms.table.td>
                        </tr>
                    </x-slot>
                    @forelse($data_detail as $index=>$item)
                        <tr>
                            <x-atoms.table.td>{{$item['nomor_nota']}}</x-atoms.table.td>
                            <x-atoms.table.td>{{$item['tgl_nota']}}</x-atoms.table.td>
                            <x-atoms.table.td>{{$item['total_bayar']}}</x-atoms.table.td>
                            <x-atoms.table.td>{{$index}}</x-atoms.table.td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak Ada Data</td>
                        </tr>
                    @endforelse
                </x-atoms.table>
            </x-molecules.card>
        </div>
        <!-- end:card-->
        <!-- begin:sidebar-->
        <div class="flex-lg-auto min-w-lg-300px">
            <x-molecules.card>
                <form class="mb-6">
                    <x-atoms.input.group label="Nomor Nota" name="nomor_nota">
                        <x-atoms.input.text wire:model.defer="nomor_nota" />
                    </x-atoms.input.group>
                    <x-atoms.input.group label="Tanggal Nota" name="tgl_nota">
                        <x-atoms.input.singledaterange wire:model.defer="tgl_nota" id="tglNota" />
                    </x-atoms.input.group>
                    <x-atoms.input.group label="Total Bayar" name="total_bayar">
                        <x-atoms.input.text wire:model.defer="total_bayar" />
                    </x-atoms.input.group>
                </form>
                <div class="row mb-5">
                    <!--begin::Col-->
                    <div class="col">
                        <x-atoms.button.btn-info class="w-100" wire:click="addLine">Add</x-atoms.button.btn-info>
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col">
                        <x-atoms.button.btn-danger class="w-100">RESET</x-atoms.button.btn-danger>
                    </div>
                    <!--end::Col-->
                </div>
                @if($update)
                    <x-atoms.button.btn-primary class="w-100" >UPDATE</x-atoms.button.btn-primary>
                @else
                    <x-atoms.button.btn-primary class="w-100" wire:click="store">SIMPAN</x-atoms.button.btn-primary>
                @endif
            </x-molecules.card>
        </div>
        <!-- end:sidebar-->
    </div>

    <!-- begin:modal-customer -->
    <x-molecules.modal size="xl" id="modal_customer" title="Modal Customer" wire:ignore.self>
        <livewire:datatables.customer-set-table />
    </x-molecules.modal>
    <!-- end:modal-customer -->

    @push('custom-scripts')
        <script>
            let modalCustomer = new bootstrap.Modal(document.getElementById('modal_customer'));
            Livewire.on('set_customer', function (){
                modalCustomer.hide();
            })

            $('#tglNota').on('change', function (e) {
                let date = $(this).data("#tglNota");
                // eval(date).set('tglLahir', $('#tglLahir').val())
                console.log(e.target.value);
                @this.tgl_nota = e.target.value;
            })
        </script>
    @endpush
</div>
