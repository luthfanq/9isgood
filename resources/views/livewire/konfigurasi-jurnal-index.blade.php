<div>
    <x-molecules.card title="Konfigurasi Akun">
        <x-slot name="toolbar">
            <x-atoms.button.btn-modal target="#modal_form">New Data</x-atoms.button.btn-modal>
        </x-slot>
        <livewire:datatables.konfigurasi-jurnal-index/>
    </x-molecules.card>
    
    <x-molecules.modal title="Form Konfigurasi Akun" id="modal_form" size="lg" wire:ignore.self>
        <form>
            <div class="row mb-6">
                <div class="col-6">
                    <x-atoms.input.group label="Konfigurasi">
                        <x-atoms.input.text name="config" wire:model.defer="config" />
                    </x-atoms.input.group>
                </div>
            </div>
            <div class="row mb-6">
                <div class="col-6">
                    <x-atoms.input.group label="Akun ID" name="akun_id" required="required">
                        <x-atoms.input.text name="akun_id" wire:model.defer="akun_id" readonly="" data-bs-target="#akun_modal"/>
                    </x-atoms.input.group>
                </div>
            </div>
            <div class="row mb-6">
                <div class="col-6">
                    <x-atoms.input.group label="Keterangan">
                        <x-atoms.input.text name="keterangan" wire:model.defer="keterangan" />
                    </x-atoms.input.group>
                </div>
            </div>
        </form>
        <x-slot name="footer">
            <x-atoms.button.btn-primary wire:click="store">Simpan</x-atoms.button.btn-primary>
        </x-slot>
        
    </x-molecules.modal>

    <x-molecules.modal title="Daftar Akun" id="akun_modal" size="xl" wire:ignore.self>
        <livewire:datatables.akun-set-table />
        <x-slot name="footer"></x-slot>
    </x-molecules.modal>

    <x-molecules.modal-notifications />

    @push('custom-scripts')
        <script>
            let modal_form = document.getElementById('modal_form');
            let modalForm = new bootstrap.Modal(modal_form);

            modal_form.addEventListener('hidden.bs.modal', evt => {
                Livewire.emit('resetForm')
            })

            let modal_akun = document.getElementById('akun_modal');
            let akunModal = new bootstrap.Modal(modal_akun);

            Livewire.on('set_akun', function (){
                akunModal.hide();
            })

            Livewire.on('hideModal', function (){
                modalForm.hide()
            })

            Livewire.on('showModal', function (){
                modalForm.show()
            })
        </script>
    @endpush
</div>
