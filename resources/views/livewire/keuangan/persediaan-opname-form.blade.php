<div>
    @if(session()->has('message'))
        <x-molecules.alert-danger>
            <span>{{session('message')}}</span>
        </x-molecules.alert-danger>
    @endif

    @if(session()->has('setHppPersen'))
        <x-molecules.alert-danger>
            <span>{{session('setHppPersen')}}</span>
            <x-atoms.button.btn-link-primary href="{{$urlConfigHpp}}">LINK</x-atoms.button.btn-link-primary>
        </x-molecules.alert-danger>
    @endif

    @if(session()->has('setJurnalTransaksi'))
        <x-molecules.alert-danger>
            <span>{{session('setJurnalTransaksi')}}</span>
            <x-atoms.button.btn-link-primary href="{{$urlConfigJurnal}}">LINK</x-atoms.button.btn-link-primary>
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
                            <x-atoms.input.group-horizontal class="mb-5" label="Gudang" name="gudang_id">
                                <x-atoms.input.select wire:model.defer="gudang_id" wire:change="setGudang">
                                    @foreach($gudang_data as $row)
                                        <option value="{{$row->id}}">{{$row->nama}}</option>
                                    @endforeach
                                </x-atoms.input.select>
                            </x-atoms.input.group-horizontal>
                        </div>
                        <div class="col-6 mb-5">
                            <x-atoms.input.group-horizontal label="Keterangan" name="keterangan">
                                <x-atoms.input.text wire:model.defer="keterangan" />
                            </x-atoms.input.group-horizontal>
                        </div>
                    </div>
                </form>
                <!-- end:form -->
                <x-atoms.table>
                    <x-slot name="head">
                        <tr>
                            <th width="15%">ID</th>
                            <th width="25%">Produk</th>
                            <th width="15%">Harga</th>
                            <th width="15%">Jumlah</th>
                            <th width="15%">sub_total</th>
                            <th width="15%"></th>
                        </tr>
                    </x-slot>
                    @forelse($data_detail as $index=>$row)
                        <tr>
                            <x-atoms.table.td>{{$row['kode_lokal']}}</x-atoms.table.td>
                            <x-atoms.table.td>{{$row['produk_nama']}}</x-atoms.table.td>
                            <x-atoms.table.td align="end">{{$row['jumlah']}}</x-atoms.table.td>
                            <x-atoms.table.td align="end">{{$row['harga']}}</x-atoms.table.td>
                            <x-atoms.table.td align="end">{{$row['sub_total']}}</x-atoms.table.td>
                            <x-atoms.table.td align="center">
                                <x-atoms.button.btn-icon wire:click="editLine({{$index}})"><i class="la la-edit fs-3"></i></x-atoms.button.btn-icon>
                                <x-atoms.button.btn-icon wire:click="destroyLine({{$index}})"><i class="la la-trash fs-3"></i></x-atoms.button.btn-icon>
                            </x-atoms.table.td>
                        </tr>
                    @empty
                        <tr>
                            <x-atoms.table.td colspan="6" align="center">Tidak Ada Data</x-atoms.table.td>
                        </tr>
                    @endforelse
                </x-atoms.table>
            </x-molecules.card>
        </div>
        <!-- end:table cards-->

        <!-- begin:form cards-->
        <div class="flex-lg-auto min-w-lg-300px">
            <x-molecules.card >
                <form class="mb-5" wire:ignore.self>
                    <x-atoms.input.group label="Produk" name="produk_nama">
                        <x-atoms.input.textarea
                            data-bs-toggle="modal"
                            data-bs-target="#modal_daftar_persediaan"
                            wire:model.defer="produk_nama"
                            readonly>
                        </x-atoms.input.textarea>
                    </x-atoms.input.group>
                    <x-atoms.input.group label="Harga Jual" name="harga_jual">
                        <x-atoms.input.text class="text-end" wire:model.defer="harga_jual" readonly/>
                    </x-atoms.input.group>
                    <x-atoms.input.group label="Harga Hpp Rekomendasi" name="hpp_rekom">
                        <x-atoms.input.text class="text-end" wire:click="setHppToHarga" wire:model.defer="hpp_rekom" readonly/>
                    </x-atoms.input.group>
                    <x-atoms.input.group label="Harga Hpp" name="harga">
                        <x-atoms.input.text class="text-end" wire:keyup="setSubTotal" wire:key="setSubTotal" wire:model="harga"/>
                    </x-atoms.input.group>
                    <x-atoms.input.group label="Jumlah" name="jumlah">
                        <x-atoms.input.text class="text-end" wire:model.defer="jumlah" readonly/>
                    </x-atoms.input.group>
                    <x-atoms.input.group label="Sub Total" name="sub_total">
                        <x-atoms.input.text class="text-end" wire:model.defer="sub_total" readonly/>
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
                        <x-atoms.button.btn-danger wire:click="setJurnalTransaksi" class="w-100">RESET</x-atoms.button.btn-danger>
                    </div>
                    <!--end::Col-->
                </div>
                @if($mode=='update')
                    <x-atoms.button.btn-primary wire:click="update" class="w-100">UPDATE</x-atoms.button.btn-primary>
                @else
                    <x-atoms.button.btn-primary wire:click="store" class="w-100">SIMPAN</x-atoms.button.btn-primary>
                @endif
            </x-molecules.card>
        </div>
        <!-- end:form cards-->

    </div>

    <!-- begin:modal-->
    <x-molecules.modal size="xl" id="modal_daftar_persediaan" title="Daftar Akun" wire:ignore.self>
        <livewire:keuangan.persediaan-awal-temp-table />
        <x-slot name="footer"></x-slot>
    </x-molecules.modal>
    <!-- end:modal -->

    @push('custom-scripts')
        <script>
            let modal_akun = document.getElementById('modal_daftar_persediaan');
            let modalAkun = new bootstrap.Modal(modal_akun);

            Livewire.on('set_produk', function (){
                modalAkun.hide();
            })
        </script>
    @endpush
</div>
