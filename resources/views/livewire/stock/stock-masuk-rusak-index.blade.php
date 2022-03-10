<div>
    <x-molecules.card title="Stock Masuk Rusak">
        <x-slot name="toolbar">
            <x-atoms.button.btn-link-primary href="{{route('stock.masuk.rusak.form')}}">New Data</x-atoms.button.btn-link-primary>
        </x-slot>
        <livewire:datatables.stock-masuk-table :kondisi="__('rusak')"/>
    </x-molecules.card>
</div>
