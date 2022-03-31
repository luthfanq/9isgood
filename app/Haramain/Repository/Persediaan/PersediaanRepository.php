<?php namespace App\Haramain\Repository\Persediaan;

use App\Models\Keuangan\Persediaan;

class PersediaanRepository
{
    /**
     * simpan data dengan data input berupa array
     * @param $data
     * @param $jenis
     * @param $gudang
     * @param $field_stock
     * @return \Illuminate\Database\Eloquent\Model|int
     */
    public static function storeArrayData($data, $jenis,  $gudang, $field_stock): \Illuminate\Database\Eloquent\Model|int
    {
        $query = Persediaan::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('jenis', $jenis)
            ->where('gudang_id', $gudang)
            ->where('produk_id', $data['produk_id'])
            ->where('harga', $data['harga']);
        if ($query->doesntExist()){
            return Persediaan::query()->create([
                'active_cash'=>session('ClosedCash'),
                'jenis'=>$jenis,// baik or buruk
                'gudang_id'=>$gudang,
                'produk_id'=>$data['produk_id'],
                'harga'=>$data['harga'],
                $field_stock=>$data['jumlah'],
            ]);
        }
        return $query->increment($field_stock, $data['jumlah']);
    }

    /**
     * simpan data dari data bentuk object
     * @param $data
     * @param $jenis
     * @param $gudang
     * @param $field_stock
     * @return \Illuminate\Database\Eloquent\Model|int
     */
    public static function storeObjectData($data, $jenis,  $gudang, $field_stock): \Illuminate\Database\Eloquent\Model|int
    {
        $query = Persediaan::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('jenis', $jenis)
            ->where('gudang_id', $gudang)
            ->where('produk_id', $data->produk_id)
            ->where('harga', $data->harga);
        if ($query->doesntExist()){
            return Persediaan::query()->create([
                'active_cash'=>session('ClosedCash'),
                'jenis'=>$jenis,// baik or buruk
                'gudang_id'=>$gudang,
                'produk_id'=>$data->produk_id,
                'harga'=>$data->harga,
                $field_stock=>$data->jumlah,
            ]);
        }
        return $query->increment($field_stock, $data->jumlah);
    }

    /**
     * rollback object data
     * @param $data
     * @param $jenis
     * @param $gudang
     * @param $field_stock
     * @return int
     */
    public static function rollbackObjectData($data, $jenis, $gudang, $field_stock)
    {
        $query = Persediaan::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('jenis', $jenis)
            ->where('gudang_id', $gudang)
            ->where('produk_id', $data->produk_id)
            ->where('harga', $data->harga);
        return $query->decrement($field_stock, $data->jumlah);
    }
}
