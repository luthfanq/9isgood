<div>
    <x-molecules.card title="Daftar Neraca Saldo Awal">
        <div class="row">
            <div class="col-8">
                <livewire:datatables.neraca-saldo-awal-table />
            </div>
            <div class="col-4">
                <form>
                    <div class="pt-4">
                        <x-atoms.input.group-horizontal label="Akun ID" name="akun_id" required="required">
                            <x-atoms.input.text name="akun_id" wire:model.defer="akun_nama"  data-bs-toggle="modal" data-bs-target="#akun_modal" readonly/>
                        </x-atoms.input.group-horizontal>
                    </div>
                    <div class="pt-4">
                        <x-atoms.input.group-horizontal label="Debet">
                            <x-atoms.input.text name="nominal_debet" wire:model.defer="nominal_debet" />
                        </x-atoms.input.group-horizontal>
                    </div>
                    <div class="pt-4">
                        <x-atoms.input.group-horizontal label="Kredit">
                            <x-atoms.input.text name="nominal_kredit" wire:model.defer="nominal_kredit" />
                        </x-atoms.input.group-horizontal>
                    </div>
                    <div class="pt-4">
                        <x-atoms.input.group-horizontal label="Keterangan" required="required">
                            <x-atoms.input.text name="keterangan" wire:model.defer="keterangan" />
                        </x-atoms.input.group-horizontal>
                    </div>
                    <div class="text-center pb-4 pt-5">
                        <x-atoms.button.btn-primary wire:click="store">Simpan</x-atoms.button.btn-primary>
                    </div>
                </form>
            </div>
        </div>
    </x-molecules.card>

  
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
