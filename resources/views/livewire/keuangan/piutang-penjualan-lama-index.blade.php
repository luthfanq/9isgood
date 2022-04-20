<div>
    <x-molecules.card title="Data Penjualan Lama">
        <x-slot name="toolbar">
            <x-atoms.button.btn-link-primary :href="route('penjualan.piutanglama.trans')">New Data</x-atoms.button.btn-link-primary>
        </x-slot>
        <livewire:datatables.keuangan.penjualan-lama-table />
    </x-molecules.card>
</div>
