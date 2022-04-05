<div>
    <x-molecules.card title="Data Stock">
        <x-slot name="toolbar">
            <x-atoms.button.btn-link-primary :href="route('stock.print.stockopname')" target="_blank" rel="noopener noreferrer">
                Report Stock Opname
            </x-atoms.button.btn-link-primary>
        </x-slot>
        <livewire:datatables.stock-inventory-table />
    </x-molecules.card>
</div>
