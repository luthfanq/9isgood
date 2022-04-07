<div>
    <x-molecules.card title="Daftar Stock Opname {{$jenis ?: ucfirst($jenis)}}">
        <livewire:datatables.stock-opname-table />
    </x-molecules.card>
    <livewire:stock.detail.stock-opname-detail-view />

</div>
