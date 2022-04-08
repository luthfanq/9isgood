<div>

    @if(session()->has('message'))
        <x-molecules.alert-danger>
            <span>{{session('message')}}</span>
        </x-molecules.alert-danger>
    @endif

    <x-molecules.card title="Form Jurnal Piutang Internal">
       
    </x-molecules.card>

</div>
