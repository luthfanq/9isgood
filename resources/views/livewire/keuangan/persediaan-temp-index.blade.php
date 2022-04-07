<div>
    <x-molecules.card title="Persediaan Awal">
        <x-slot name="toolbar">
            <x-atoms.button.btn-primary wire:click="generate">Generate</x-atoms.button.btn-primary>
        </x-slot>
        <livewire:keuangan.persediaan-awal-temp-table />
    </x-molecules.card>
</div>
