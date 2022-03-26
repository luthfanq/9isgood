<div>
    <x-molecules.card title="Konfigurasi Akun">
        <x-slot name="toolbar">

        </x-slot>
        <div class="row">
            <div class="col-8">
                <livewire:datatables.konfigurasi-jurnal-index/>
            </div>
            <div class="col-4">
                <form>
                    <div class="mb-5">
                        <x-atoms.input.group label="Konfigurasi">
                            <x-atoms.input.text name="config" wire:model.defer="config" />
                        </x-atoms.input.group>
                    </div>
                    <div class="mb-5">
                        <x-atoms.input.group label="Akun ID" name="akun_id" required="required">
                            <x-atoms.input.text name="akun_id" wire:model.defer="akun_nama" readonly="" data-bs-toggle="modal" data-bs-target="#akun_modal"/>
                        </x-atoms.input.group>
                    </div>
                    <div class="mb-5">
                        <x-atoms.input.group label="Keterangan">
                            <x-atoms.input.text name="keterangan" wire:model.defer="keterangan" />
                        </x-atoms.input.group>
                    </div>
                    <div class="mb-5">
                        <x-atoms.button.btn-primary wire:click="store">Simpan</x-atoms.button.btn-primary>
                    </div>
                </form>
            </div>
        </div>
    </x-molecules.card>

    <x-molecules.modal title="Daftar Akun" id="akun_modal" size="xl" wire:ignore.self>
        <livewire:datatables.akun-set-table />
        <x-slot name="footer"></x-slot>
    </x-molecules.modal>

    <x-molecules.modal-notifications />

    @push('custom-scripts')
        <script>
            let modal_akun = document.getElementById('akun_modal');
            let akunModal = new bootstrap.Modal(modal_akun);

            Livewire.on('set_akun', function (){
                akunModal.hide();
            })
        </script>
    @endpush
</div>
