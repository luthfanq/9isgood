<div>
    @if(session()->has('message'))
        <x-molecules.alert-danger>
            <span>{{session('message')}}</span>
        </x-molecules.alert-danger>
    @endif

    @error('data_detail')
        <x-molecules.alert-danger>
            <span>{{$message}}</span>
        </x-molecules.alert-danger>
    @enderror

    <div class="d-flex flex-column flex-lg-row">
        <!-- begin:table cards-->
        <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
            <x-molecules.card>
                <!-- begin:form -->
                <form>
                    <div class="row">
                        <div class="col-6 mb-5">
                            <x-atoms.input.group-horizontal class="mb-5" label="Tujuan" name="tujuan">
                                <x-atoms.input.text wire:model.defer="tujuan" />
                            </x-atoms.input.group-horizontal>
                            <x-atoms.input.group-horizontal label="Keterangan" name="keterangan">
                                <x-atoms.input.text wire:model.defer="keterangan" />
                            </x-atoms.input.group-horizontal>
                        </div>
                        <div class="col-6 mb-5">
                            <x-atoms.input.group-horizontal label="Tanggal" name="tgl_jurnal">
                                <x-atoms.input.singledaterange id="tglJurnal" wire:model.defer="tgl_jurnal"/>
                            </x-atoms.input.group-horizontal>
                        </div>
                    </div>
                </form>
                <!-- end:form -->
                <x-atoms.table>
                    <x-slot name="head">
                        <tr>
                            <th width="10%">ID</th>
                            <th width="35%">Akun</th>
                            <th width="20%">Debet</th>
                            <th width="20%">Kredit</th>
                            <th width="20%"></th>
                        </tr>
                    </x-slot>
                    @forelse($data_detail as $index=>$row)
                        <tr>
                            <x-atoms.table.td>{{$row['akun_kode']}}</x-atoms.table.td>
                            <x-atoms.table.td>{{$row['akun_nama']}}</x-atoms.table.td>
                            <x-atoms.table.td align="end">{{($row['nominal_debet']) ? rupiah_format($row['nominal_debet']) : null}}</x-atoms.table.td>
                            <x-atoms.table.td align="end">{{($row['nominal_kredit']) ? rupiah_format($row['nominal_kredit']) : null}}</x-atoms.table.td>
                            <x-atoms.table.td align="center">
                                <x-atoms.button.btn-icon wire:click="editLine({{$index}})"><i class="la la-edit fs-3"></i></x-atoms.button.btn-icon>
                                <x-atoms.button.btn-icon wire:click="destroyLine({{$index}})"><i class="la la-trash fs-3"></i></x-atoms.button.btn-icon>
                            </x-atoms.table.td>
                        </tr>
                    @empty
                        <tr>
                            <x-atoms.table.td colspan="5" align="center">Tidak Ada Data</x-atoms.table.td>
                        </tr>
                    @endforelse
                </x-atoms.table>
            </x-molecules.card>
        </div>
        <!-- end:table cards-->

        <!-- begin:form cards-->
        <div class="flex-lg-auto min-w-lg-300px">
            <x-molecules.card>
                <form class="mb-5">
                    <x-atoms.input.group label="Akun" name="akun_nama">
                        <x-atoms.input.text data-bs-toggle="modal" data-bs-target="#modal_daftar_akun" wire:model.defer="akun_nama" readonly/>
                    </x-atoms.input.group>
                    <x-atoms.input.group label="Nominal Debet" name="nominal_debet">
                        <x-atoms.input.text class="text-end" wire:model.defer="nominal_debet"/>
                    </x-atoms.input.group>
                    <x-atoms.input.group label="Nominal Kredit" name="nominal_kredit">
                        <x-atoms.input.text class="text-end" wire:model.defer="nominal_kredit"/>
                    </x-atoms.input.group>
                </form>
                <div class="separator separator-dashed mb-8"></div>
                <div class="row mb-5">
                    <!--begin::Col-->
                    <div class="col">
                        @if($update==true)
                            <x-atoms.button.btn-info wire:click="updateLine" class="w-100">Update</x-atoms.button.btn-info>
                        @else
                            <x-atoms.button.btn-info wire:click="addLine" class="w-100">Add</x-atoms.button.btn-info>
                        @endif
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col">
                        <x-atoms.button.btn-danger class="w-100">RESET</x-atoms.button.btn-danger>
                    </div>
                    <!--end::Col-->
                </div>
                @if($mode=='update')
                    <x-atoms.button.btn-primary wire:click="update" class="w-100">SIMPAN</x-atoms.button.btn-primary>
                @else
                    <x-atoms.button.btn-primary wire:click="store" class="w-100">SIMPAN</x-atoms.button.btn-primary>
                @endif
            </x-molecules.card>
        </div>
        <!-- end:form cards-->

    </div>

    <!-- begin:modal-->
    <x-molecules.modal size="xl" id="modal_daftar_akun" title="Daftar Akun" wire:ignore.self>
        <livewire:datatables.akun-set-table />
        <x-slot name="footer"></x-slot>
    </x-molecules.modal>
    <!-- end:modal -->

    @push('custom-scripts')
        <script>
            let modal_akun = document.getElementById('modal_daftar_akun');
            let modalAkun = new bootstrap.Modal(modal_akun);

            Livewire.on('set_akun', function (){
                modalAkun.hide();
            })

            $('#tglJurnal').on('change', function (e) {
                let date = $(this).data("#tglJurnal");
                // eval(date).set('tglLahir', $('#tglLahir').val())
                console.log(e.target.value);
                @this.tgl_jurnal = e.target.value;
            })
        </script>
    @endpush
</div>
