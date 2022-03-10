<div>
    <x-molecules.card title="Stock Masuk Baik">
        <x-slot name="toolbar">
            <x-atoms.button.btn-link-primary href="{{route('stock.masuk.baik.form')}}">New Data</x-atoms.button.btn-link-primary>
        </x-slot>
        <livewire:datatables.stock-masuk-table :kondisi="__('baik')"/>
    </x-molecules.card>
</div>
