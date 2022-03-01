<div>
    <x-molecules.card title="Data Produk Kategori">
        <x-slot name="toolbar">
            <x-atoms.button.btn-modal target="#modal_form">New Data</x-atoms.button.btn-modal>
        </x-slot>
        <livewire:produk-kategori-table />
    </x-molecules.card>

    <x-molecules.modal title="Form Produk Kategori" id="modal_form" size="lg">
        <form>
            <x-atoms.input.group label="ID Lokal" required="required">
                <x-atoms.input.text name="id_lokal"/>
            </x-atoms.input.group>
            <x-atoms.input.group label="Nama Kategori" required="required">
                <x-atoms.input.text name="nama_kategori"/>
            </x-atoms.input.group>
            <x-atoms.input.group label="Keterangan">
                <x-atoms.input.text name="keterangan"/>
            </x-atoms.input.group>
        </form>
        <x-slot name="footer"></x-slot>
    </x-molecules.modal>

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
