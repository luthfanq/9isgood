<div>
    <x-molecules.card title="Nilai HPP">
        @foreach($configVar as $index=>$item)
            <div class="row">
                <div class="col-8">
                    <x-atoms.input.group-horizontal :label="$item->deskripsi">
                        <x-atoms.input.text wire:model.defer="persen.{{$item->id}}"/>
                    </x-atoms.input.group-horizontal>
                </div>
                <div class="col-4">
                    <x-atoms.button.btn-info wire:click="update({{$item->id}})">SIMPAN</x-atoms.button.btn-info>
                </div>
            </div>
        @endforeach
    </x-molecules.card>
</div>
