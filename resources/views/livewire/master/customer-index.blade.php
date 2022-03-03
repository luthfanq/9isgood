<div>
    <x-molecules.card title="Data Customer">
        <x-slot name="toolbar">
            <x-atoms.button.btn-modal target="#modal_form">New Data</x-atoms.button.btn-modal>
        </x-slot>
        <livewire:datatables.customer-table />
    </x-molecules.card>

    <x-molecules.modal title="Form Customer" id="modal_form" size="lg" wire:ignore.self>
        <form>
            <x-atoms.input.group label="Nama" required="required">
                <x-atoms.input.text name="nama" wire:model.defer="nama" />
            </x-atoms.input.group>
            <div class="row">
                <div class="col-6">
                    <x-atoms.input.group label="Diskon" required="required">
                        <x-atoms.input.text name="diskon" wire:model.defer="diskon" />
                    </x-atoms.input.group>
                </div>
                <div class="col-6">
                    <x-atoms.input.group label="Telepon">
                        <x-atoms.input.text name="telepon" wire:model.defer="telepon" />
                    </x-atoms.input.group>
                </div>
            </div>
            <x-atoms.input.group label="Alamat">
                <x-atoms.input.text name="alamat" wire:model.defer="alamat" />
            </x-atoms.input.group>
            <x-atoms.input.group label="Keterangan">
                <x-atoms.input.text name="keterangan" wire:model.defer="keterangan" />
            </x-atoms.input.group>
        </form>
        <x-slot name="footer">
            <x-atoms.button.btn-primary wire:click="store">Simpan</x-atoms.button.btn-primary>
        </x-slot>
    </x-molecules.modal>

    <x-molecules.modal-notifications />

    @push('custom-scripts')
        <script>
            let modal_form = document.getElementById('modal_form');
            let modalForm = new bootstrap.Modal(modal_form);

            modal_form.addEventListener('hidden.bs.modal', evt => {
                Livewire.emit('resetForm')
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
