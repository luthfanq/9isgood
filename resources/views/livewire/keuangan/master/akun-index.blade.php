<div>
    <x-molecules.card title="Daftar Akun">
        <x-slot name="toolbar">
            <x-atoms.button.btn-modal target="#modal_form">New Data</x-atoms.button.btn-modal>
        </x-slot>
        <livewire:datatables.keuangan.akun-table />
    </x-molecules.card>

    <x-molecules.modal title="Form Akun" id="modal_form" size="lg" wire:ignore.self>
        <form>
            <x-atoms.input.group label="Kode" required="required">
                <x-atoms.input.text name="kode" wire:model.defer="kode" />
            </x-atoms.input.group>
            <div class="row">
                <div class="col-6">
                    <x-atoms.input.group label="Tipe" required="required">
                        <x-atoms.input.select name="akun_tipe_id" wire:model.defer="akun_tipe_id">
                            <option>Dipilih</option>
                            @foreach($akun_tipe_data as $row)
                                <option value="{{$row->id}}">{{$row->deskripsi}}</option>
                            @endforeach
                        </x-atoms.input.select>
                    </x-atoms.input.group>
                </div>
                <div class="col-6">
                    <x-atoms.input.group label="Kategori">
                        <x-atoms.input.select name="akun_kategori_id" wire:model.defer="akun_kategori_id">
                            <option>Dipilih</option>
                            @foreach($akun_kategori_data as $row)
                                <option value="{{$row->id}}">{{$row->deskripsi}}</option>
                            @endforeach
                        </x-atoms.input.select>
                    </x-atoms.input.group>
                </div>
            </div>
            <x-atoms.input.group label="Deskripsi">
                <x-atoms.input.text name="deskripsi" wire:model.defer="deskripsi" />
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
