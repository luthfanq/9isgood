<?php namespace App\Haramain\Repository\Persediaan;

use App\Models\Keuangan\PersediaanAwalTemporary;

class PersediaanAwalTempRepo
{
    public function store($datamaster, $datadetail)
    {
        return PersediaanAwalTemporary::query()->create([
            'active_cash'=>session('ClosedCash'),
            'gudang_id'=>$datamaster->gudang_id,
            'kondisi'=>$datamaster->kondisi ?? $datamaster->jenis,
            'produk_id'=>$datadetail->produk_id,
            'jumlah'=>$datadetail->jumlah,
        ]);
    }

    public function update($datamaster, $datadetail)
    {
        $query = PersediaanAwalTemporary::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('gudang_id', $datamaster->gudang_id)
            ->where('kondisi', $datamaster->kondisi ?? $datamaster->jenis)
            ->where('produk_id', $datadetail->produk_id);

        // jika data tidak ada, maka dibuat baru
        if ($query->doesntExist()){
            return $this->store($datamaster, $datadetail);
        }

        return $query;
    }

    public function updateIncrement($datamaster, $datadetail)
    {
        return $this->update($datamaster, $datadetail)->increment('jumlah', $datadetail->jumlah);
    }

    public function updateDecrement($datamaster, $datadetail)
    {
        return $this->update($datamaster, $datadetail)->decrement('jumlah', $datadetail->jumlah);
    }
}
