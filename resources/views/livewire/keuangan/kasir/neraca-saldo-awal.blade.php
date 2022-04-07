<div>
    <x-molecules.card title="Daftar Neraca Saldo Awal">
        <livewire:datatables.neraca-saldo-awal-table />
    </x-molecules.card>


    <x-molecules.modal title="Form Neraca Saldo Awal" id="modal_form" size="lg" wire:ignore.self>
        <form>
            <div class="row">
                <x-atoms.input.group label="Akun ID" name="akun_id" required="required">
                    <x-atoms.input.text name="akun_id" wire:model.defer="deskripsi"  data-bs-toggle="modal" data-bs-target="#akun_modal" readonly/>
                </x-atoms.input.group>
            </div>
            <x-atoms.input.group label="Keterangan">
                <x-atoms.input.text name="keterangan" wire:model.defer="keterangan" />
            </x-atoms.input.group>
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

            Livewire.on('hideModal', function (){
                modalForm.hide()
            })

            Livewire.on('showModal', function (){
                modalForm.show()
            })
        </script>
    @endpush
</div>
