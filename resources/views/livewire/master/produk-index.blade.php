<div>
    <x-molecules.card title="Data Produk Harga">
        <x-slot name="toolbar">
            <x-atoms.button.btn-modal target="#modal_form">New Data</x-atoms.button.btn-modal>
        </x-slot>
        <livewire:datatables.produk-table />
    </x-molecules.card>

    <x-molecules.modal title="Form Produk" id="modal_form" size="lg" wire:ignore.self>
        <form>
            <div class="row">
                <div class="col-6">
                    <x-atoms.input.group label="Kategori" required="required">
                        <x-atoms.input.select name="kategori" wire:model.defer="kategori">
                            <option>Dipilih</option>
                            @foreach($kategori_data as $item)
                                <option value="{{$item->id}}">{{$item->nama}}</option>
                            @endforeach
                        </x-atoms.input.select>
                    </x-atoms.input.group>
                </div>
                <div class="col-6">
                    <x-atoms.input.group label="Kategori Harga" required="required">
                        <x-atoms.input.select name="kategori_harga" wire:model.defer="kategori_harga">
                            <option>Dipilih</option>
                            @foreach($kategori_harga_data as $item)
                                <option value="{{$item->id}}">{{$item->nama}}</option>
                            @endforeach
                        </x-atoms.input.select>
                    </x-atoms.input.group>
                </div>
            </div>
            <x-atoms.input.group label="Nama" required="required">
                <x-atoms.input.text name="nama" wire:model.defer="nama" />
            </x-atoms.input.group>
            <x-atoms.input.group label="Harga" required="required">
                <x-atoms.input.text name="harga" wire:model.defer="harga" />
            </x-atoms.input.group>
            <div class="row">
                <div class="col-6">
                    <x-atoms.input.group label="Kode Lokal">
                        <x-atoms.input.text name="kode_lokal" wire:model.defer="kode_lokal" />
                    </x-atoms.input.group>
                </div>
                <div class="col-6">
                    <x-atoms.input.group label="Penerbit">
                        <x-atoms.input.text name="penerbit" wire:model.defer="penerbit" />
                    </x-atoms.input.group>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <x-atoms.input.group label="Hal">
                        <x-atoms.input.text name="hal" wire:model.defer="hal" />
                    </x-atoms.input.group>
                </div>
                <div class="col-4">
                    <x-atoms.input.group label="Cover">
                        <x-atoms.input.text name="cover" wire:model.defer="cover" />
                    </x-atoms.input.group>
                </div>
                <div class="col-4">
                    <x-atoms.input.group label="Penerbit">
                        <x-atoms.input.text name="penerbit" wire:model.defer="penerbit" />
                    </x-atoms.input.group>
                </div>
            </div>
            <x-atoms.input.group label="Deskripsi">
                <x-atoms.input.text name="deskripsi" wire:model.defer="deskripsi" />
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
