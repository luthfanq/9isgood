<x-molecules.modal size="sm" id="modalDeleteNotification">
    <p>Apakah anda yakin menghapus data?</p>
    <x-slot name="footer">
        <x-atoms.button.btn-danger onclick="Livewire.emit('confirmDestroy')">
            Hapus
        </x-atoms.button.btn-danger>
    </x-slot>
</x-molecules.modal>

@push('custom-scripts')
    <script>
        let modal_delete_notification = document.getElementById('modalDeleteNotification');
        let modalDeleteNotification = new bootstrap.Modal(modal_delete_notification);

        Livewire.on('hideDeleteNotification', ()=>{
            modalDeleteNotification.hide();
        })

        Livewire.on('showDeleteNotification', ()=>{
            modalDeleteNotification.show();
        })
    </script>
@endpush
