<?php namespace App\Haramain\Repository;

use App\Models\Keuangan\JurnalHPP;

class HppRepository
{
    public static function getSaldo()
    {
        $query = JurnalHPP::query()
            ->where('active_cash', session('ClosedCash'))
            ->latest('id');

        if ($query->doesntExist()){
            return 0;
        }

        return $query->first()->saldo;
    }

    // store
    public static function storeHPP($data, $stock, $jurnal)
    {
        $saldo = ($data->type == 'debet') ? $data->nominal_debet : -($data->nominal_kredit);

        $jurnalHPP = JurnalHPP::query()->create([
            'active_cash'=>session('ClosedCash'),
            'type'=>$data->type, // debet/kredit
            'nominal_debet'=>$data->nominal_debet ?? 0,
            'nominal_kredit'=>$data->nominal_kredit ?? 0,
            'nominal_saldo'=>$saldo + self::getSaldo(),
        ]);
        $jurnalHPP->jurnalable_hpp()->associate($stock);
        $jurnalHPP->stockable_hpp()->associate($jurnal);
        return $jurnalHPP->save();
    }

    // update
    public static function updateHPP($hpp_id, $data, $stock, $jurnal)
    {
        $saldo = ($data->type == 'debet') ? $data->nominal_debet : -($data->nominal_kredit);

        $query = JurnalHPP::query()->find($hpp_id);

        // rollback saldo first


        $hpp = JurnalHPP::query()->find($hpp_id)
            ->update([
                'nominal_debet'=>$data->nominal_debet ?? 0,
                'nominal_kredit'=>$data->nominal_kredit ?? 0,
                'nominal_saldo'=>$saldo + self::getSaldo(),
            ]);
    }

    // delete
}
