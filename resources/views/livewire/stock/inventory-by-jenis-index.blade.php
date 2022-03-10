<div>
    <x-molecules.card title="Stock {{ucwords($gudang_nama)}} {{ucwords($jenis)}}">
        <livewire:datatables.stock-inventory-by-kondisi-table :jenis="$jenis" :gudang="$gudang"/>
    </x-molecules.card>
</div>
