<div>
    <x-molecules.card title="Data Penjualan">
        <x-slot name="toolbar">
            <x-atoms.button.btn-link-primary href="{{route('penjualan.trans')}}">New Data</x-atoms.button.btn-link-primary>
        </x-slot>
        <livewire:datatables.penjualan-table />
    </x-molecules.card>
    <livewire:penjualan.penjualan-detail-view />
</div>
