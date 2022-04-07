<?php namespace App\Haramain\Repository\Persediaan;

use App\Models\Keuangan\Persediaan;

class PersediaanRepository
{
    public function store(object $dataMaster, array $dataDetail, $field)
    {
        $persediaan = Persediaan::query()->create([
            'active_cash'=>session('ClosedCash'),
            'jenis'=>$dataMaster->kondisi ?? $dataMaster->jenis,// baik or buruk
            'gudang_id'=>$dataMaster->gudang_id,
            'produk_id'=>$dataDetail['produk_id'],
            'harga'=>$dataDetail['harga_hpp'],
            $field=>$dataDetail['jumlah']
        ]);

        if ($field == 'stock_masuk' || 'stock_opname'){
            $persediaan->increment('stock_saldo', $dataDetail['jumlah']);
        }

        if ($field == 'stock_keluar'){
            $persediaan->decrement('stock_saldo', $dataDetail['jumlah']);
        }
        return $persediaan->id;
    }

    public function update(object $dataMaster, array $dataDetail, $field)
    {
        $persediaan = Persediaan::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('jenis', $dataMaster->kondisi ?? $dataMaster->jenis)
            ->where('gudang_id', $dataMaster->gudang_id)
            ->where('produk_id', $dataDetail['produk_id'])
            ->where('harga', $dataDetail['harga_hpp']);

        if ($persediaan->doesntExist()){
            return $this->store($dataMaster, $dataDetail, $field);
        }

        $persediaan = $persediaan->first();

        $persediaan->increment($field, $dataDetail['jumlah']);

        if ($field == 'stock_masuk' || 'stock_opname'){
            $persediaan->increment('stock_saldo', $dataDetail['jumlah']);
        }

        if ($field == 'stock_keluar'){
            $persediaan->decrement('stock_saldo', $dataDetail['jumlah']);
        }
        return $persediaan->id;
    }

    public function rollback(object $dataMaster, object $dataDetail, $field)
    {
        $persediaan = Persediaan::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('jenis', $dataMaster->kondisi ?? $dataMaster->jenis)
            ->where('gudang_id', $dataMaster->gudang_id)
            ->where('produk_id', $dataDetail['produk_id'])
            ->where('harga', $dataDetail['harga_hpp'])->first();

        $persediaan->decrement($field, $dataDetail['jumlah']);

        if ($field == 'stock_masuk' || 'stock_opname'){
            $persediaan->decrement('stock_saldo', $dataDetail['jumlah']);
        }

        if ($field == 'stock_keluar'){
            $persediaan->increment('stock_saldo', $dataDetail['jumlah']);
        }
        return $persediaan->id;
    }
}
