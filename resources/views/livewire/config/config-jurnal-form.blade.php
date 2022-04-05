<div>
    <x-molecules.card title="Konfigurasi Jurnal">
        @foreach($configJurnal as $item)
            <div class="row mb-6">
                <div class="col-8">
                    <x-atoms.input.group-horizontal :label="Str::headline($item->config)" name="akun_id.{{$item->config}}">
                        <x-atoms.input.text wire:model.defer="akun_name.{{$item->config}}"
                                            wire:click="setConfigForAkun('{{$item->config}}')"
                                            data-bs-toggle="modal" data-bs-target="#modal_set_akun"
                                            readonly/>
                    </x-atoms.input.group-horizontal>
                </div>
                <div class="col-4">
                    <x-atoms.button.btn-info wire:click="update('{{$item->config}}')">SIMPAN</x-atoms.button.btn-info>
                </div>
            </div>
        @endforeach
    </x-molecules.card>

    <x-molecules.modal size="xl" id="modal_set_akun" wire:ignore.self>
        <livewire:datatables.akun-set-table />
    </x-molecules.modal>

    @push('custom-scripts')
        <script>
            let modal_set_akun = document.getElementById('modal_set_akun');
            let modalSetAkun = new bootstrap.Modal(modal_set_akun);

            Livewire.on('set_akun', function (){
                modalSetAkun.hide();
            })
        </script>
    @endpush
</div>
