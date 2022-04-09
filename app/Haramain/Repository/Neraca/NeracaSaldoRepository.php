<?php namespace App\Haramain\Repository\Neraca;

use App\Models\Keuangan\NeracaSaldo;

class NeracaSaldoRepository
{
    public function store($data)
    {
         return NeracaSaldo::query()->create([
            'active_cash'=>session('ClosedCash'),
            'akun_id'=>$data['akun_id'],
            'debet'=>$data['nominal_debet'],
            'kredit'=>$data['nominal_kredit'],
        ]);
    }

    public function update($data)
    {
        $neraca = NeracaSaldo::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('akun_id', $data['akun_id']);

        if ($neraca->doesntExist()){
            return $this->store($data);
        }
        $neraca = $neraca->first();

        if (isset($data['akun_debet'])){
            return $neraca->increment('debet', $data['nominal_debet']);
        }

        return $neraca->increment('kredit', $data['nominal_kredit']);
    }

    public function updateOneRow($akunId, $nominalDebet, $nominalKredit)
    {
        $neraca = NeracaSaldo::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('akun_id', $akunId);

        if ($neraca->doesntExist()){
            return NeracaSaldo::query()->create([
                'active_cash'=>session('ClosedCash'),
                'akun_id'=>$akunId,
                'debet'=>$nominalDebet,
                'kredit'=>$nominalKredit,
            ]);
        }
        $neraca = $neraca->first();

        if ($nominalDebet != null){
            return $neraca->increment('debet', $nominalDebet);
        }

        return $neraca->increment('kredit', $nominalKredit);
    }

    public function rollback($data)
    {
        $neraca = NeracaSaldo::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('akun_id', $data->akun_id)->first();

        if ($data->nominal_debet > 0){
            return $neraca->decrement('debet', $data->nominal_debet);
        }

        return $neraca->decrement('kredit', $data->nominal_kredit);
    }
}
