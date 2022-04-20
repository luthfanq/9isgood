<?php namespace App\Haramain\Repository\Persediaan;

use App\Models\Keuangan\Persediaan;

class PersediaanRepository
{
    /**
     * get data from persediaan table
     * digunakan untuk menyimpan pada transaksi persediaan transaksi
     * @param $produk_id
     * @param $gudang_id
     * @param $jumlah
     * @return array
     */
    public function getProdukForMutasi($produk_id, $gudang_id, $jumlah)
    {
        $query = Persediaan::query()
            ->where('produk_id', $produk_id)
            ->where('active_cash', session('ClosedCash'))
            ->where('gudang_id', $gudang_id);
        $queryGet = $query->get();

        $data = [];

        // check jumlah produk yang ada
        $count = $query->count();

        $i = $jumlah;
        for ($y = 0; $y < $count ;$y++){
            if ($i < $queryGet[$y]->stock_saldo){
                $data [] = (object) [
                    'produk_id'=>$queryGet[$y]->produk_id,
                    'harga'=>$queryGet[$y]->harga,
                    'jumlah'=>$i
                ];
                break;
            } else {
                // jika stock saldo adalah 0
                // maka dilewati (tidak ada proses)
                if ($queryGet[$y]->stock_saldo <= 0){
                    continue;
                }
                // jika data terakhir dan masih ada sisa produk
                // maka semua barang akan menjadi saldo_keluar
                if ($y == $count-1){
                    $data [] = (object) [
                        'produk_id'=>$queryGet[$y]->produk_id,
                        'harga'=>$queryGet[$y]->harga,
                        'jumlah'=>$i
                    ];
                }
                $data[] = (object)[
                    'produk_id'=>$queryGet[$y]->produk_id,
                    'harga'=>$queryGet[$y]->harga,
                    'jumlah'=>$queryGet[$y]->stock_saldo,
                ];
            }
        }
        return $data;
    }

    public function store(object $dataMaster, array $dataDetail, $field)
    {
        $persediaan = Persediaan::query()->create([
            'active_cash'=>session('ClosedCash'),
            'jenis'=>$dataMaster->kondisi ?? $dataMaster->jenis,// baik or buruk
            'gudang_id'=>$dataMaster->gudang_id,
            'produk_id'=>$dataDetail['produk_id'],
            'harga'=>$dataDetail['harga_hpp'] ?? $dataDetail['harga'],
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

    public function storeObject(object $dataMaster, object $dataDetail, $field)
    {
        $persediaan = Persediaan::query()->create([
            'active_cash'=>session('ClosedCash'),
            'jenis'=>$dataMaster->kondisi ?? $dataMaster->jenis,// baik or buruk
            'gudang_id'=>$dataMaster->gudang_id,
            'produk_id'=>$dataDetail->produk_id,
            'harga'=>$dataDetail->harga_hpp ?? $dataDetail->harga,
            $field=>$dataDetail->jumlah
        ]);

        if ($field == 'stock_masuk' || 'stock_opname'){
            $persediaan->increment('stock_saldo', $dataDetail->jumlah);
        }

        if ($field == 'stock_keluar'){
            $persediaan->decrement('stock_saldo', $dataDetail->jumlah);
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
            ->where('harga', $dataDetail['harga_hpp'] ?? $dataDetail['harga']);

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

    public function updateObject(object $dataMaster, object $dataDetail, $field)
    {
        $persediaan = Persediaan::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('jenis', $dataMaster->kondisi ?? $dataMaster->jenis)
            ->where('gudang_id', $dataMaster->gudang_id)
            ->where('produk_id', $dataDetail->produk_id)
            ->where('harga', $dataDetail->harga_hpp ?? $dataDetail->harga);

        if ($persediaan->doesntExist()){
            return $this->storeObject($dataMaster, $dataDetail, $field);
        }

        $persediaan = $persediaan->first();

        $persediaan->increment($field, $dataDetail->jumlah);

        if ($field == 'stock_masuk' || 'stock_opname'){
            $persediaan->increment('stock_saldo', $dataDetail->jumlah);
        }

        if ($field == 'stock_keluar'){
            $persediaan->decrement('stock_saldo', $dataDetail->jumlah);
        }
        return $persediaan->id;
    }

    public function updatePenjualan($dataMaster, $dataDetail)
    {
        //
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

    public function rollbackObject(object $dataMaster, object $dataDetail, $field, $kondisi=null)
    {
        $persediaan = Persediaan::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('jenis', $kondisi ?? $dataMaster->kondisi ?? $dataMaster->jenis)
            ->where('gudang_id', $dataMaster->gudang_id)
            ->where('produk_id', $dataDetail->produk_id)
            ->where('harga', $dataDetail->harga)->first();

        $persediaan->decrement($field, $dataDetail->jumlah);

        if ($field == 'stock_masuk' || 'stock_opname'){
            $persediaan->decrement('stock_saldo', $dataDetail->jumlah);
        }

        if ($field == 'stock_keluar'){
            $persediaan->increment('stock_saldo',$dataDetail->jumlah);
        }
        return $persediaan->id;
    }
}
