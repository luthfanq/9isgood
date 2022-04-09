<div>
    <x-molecules.card title="Daftar Piutang Penjualan Awal">
        <x-slot name="toolbar">
            <x-atoms.button.btn-link-primary href="{{route('penjualan.piutang.trans')}}">New Data</x-atoms.button.btn-link-primary>
        </x-slot>
        <livewire:datatables.keuangan.jurnal-set-piutang-awal-table />
    </x-molecules.card>
</div>
