<div>
    <x-molecules.card title="Daftar Stock Akhir">
        <x-slot name="toolbar">
            @if($lastSessionCondition)
                <x-atoms.button.btn-primary wire:click="setLastSession">Periode Sekarang</x-atoms.button.btn-primary>
            @else
                <x-atoms.button.btn-primary wire:click="setLastSession">Periode Sebelumnya</x-atoms.button.btn-primary>
            @endif
        </x-slot>
        <livewire:datatables.stock-akhir-table />
    </x-molecules.card>

    <x-molecules.modal-notifications />
</div>
