<div>
    <x-molecules.card title="Form Penerimaan Penjualan">
        <form>
            <div class="row">
                <div class="col-6">
                    <x-atoms.input.group-horizontal label="Customer">
                        <x-atoms.input.text name="customer_id" wire:model.defer="customer_id"/>
                    </x-atoms.input.group-horizontal>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <x-atoms.input.group-horizontal label="Tanggal">
                        <x-atoms.input.singledaterange/>
                    </x-atoms.input.group-horizontal>
                </div>
            </div>
        </form>
    </x-molecules.card>
</div>
