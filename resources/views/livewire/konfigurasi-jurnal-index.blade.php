<div>
    <x-molecules.card title="Konfigurasi Akun">        
        <table class="col-5">
        <livewire:datatables.konfigurasi-jurnal-index/>
        </table>
        <div class="col-4 border">
            <form wire:ignore.self> 
                <div class="pt-4">
                    <x-atoms.input.group-horizontal label="Konfigurasi" required="required">
                        <x-atoms.input.text name="config" wire:model.defer="config" />
                    </x-atoms.input.group-horizontal>
                </div>
                <div class="pt-4">
                    <x-atoms.input.group-horizontal label="Akun ID" name="akun_id" required="required">
                        <x-atoms.input.text name="akun_id" wire:model.defer="deskripsi"  data-bs-toggle="modal" data-bs-target="#akun_modal" readonly/>
                    </x-atoms.input.group-horizontal>
                </div>
                <div class="pt-4">
                    <x-atoms.input.group-horizontal label="Keterangan">
                        <x-atoms.input.text name="keterangan" wire:model.defer="keterangan" />
                    </x-atoms.input.group-horizontal>
                </div>
            </form>
            
            <div class="text-center pb-4 pt-5">
                <x-atoms.button.btn-primary wire:click="store">Simpan</x-atoms.button.btn-primary>
            </div>
        </div>
    </x-molecules.card>

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
