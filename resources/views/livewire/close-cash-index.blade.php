<div>
    <x-molecules.card title="Closed Cash">
        <x-atoms.table>
            <x-slot name="head">
                <tr>
                    <th>User</th>
                    <th>Active</th>
                    <th>Closed</th>
                    <th>Started</th>
                    <th>Ended</th>
                </tr>
            </x-slot>
            @foreach($data_forView as $item)
                <tr>
                    <x-atoms.table.td width="20%">
                        {{ucwords($item->users->name)}}
                    </x-atoms.table.td>
                    <x-atoms.table.td width="20%">
                        {{$item->active}}
                    </x-atoms.table.td>
                    <x-atoms.table.td width="20%">
                        {{$item->closed}}
                    </x-atoms.table.td>
                    <x-atoms.table.td width="20%" align="center">
                        {{$item->created_at}}
                    </x-atoms.table.td>
                    <x-atoms.table.td width="20%" align="center">
                        @if($item->closed)
                            {{$item->updated_at}}
                        @endif
                    </x-atoms.table.td>
                </tr>
            @endforeach
        </x-atoms.table>

        <x-slot name="footer">
            <x-atoms.button.btn-modal wire:click="store">Closed</x-atoms.button.btn-modal>
        </x-slot>
    </x-molecules.card>
</div>
