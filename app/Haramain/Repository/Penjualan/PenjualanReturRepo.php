<?php namespace App\Haramain\Repository\Penjualan;

use App\Haramain\Repository\Stock\StockInventoryRepo;
use App\Haramain\Repository\StockMasuk\StockMasukRepository;
use App\Models\Penjualan\PenjualanRetur;
use Illuminate\Database\Eloquent\Model;

class PenjualanReturRepo
{
    public function kode($kondisi)
    {
        // query
        $query = PenjualanRetur::query()
            ->where('active_cash', session('ClosedCash'))
            ->where('jenis_retur', $kondisi)
            ->latest('kode');

        $kode = ($kondisi == 'baik') ? 'RB' : 'RR';

        // check last num
        if ($query->doesntExist()){
            return "0001/{$kode}/".date('Y');
        }

        $num = (int)$query->first()->last_num_trans + 1 ;
        return sprintf("%04s", $num)."/{$kode}/".date('Y');
    }

    public function store(object $data)
    {
        $kode = StockMasukRepository::kode($data->kondisi);
        // store penjualan retur
        // return object penjualan retur
        $penjualanRetur = PenjualanRetur::query()->create([
            'kode'=>$this->kode($data->kondisi),
            'active_cash'=>session('ClosedCash'),
            'jenis_retur'=>$data->kondisi,
            'customer_id'=>$data->customer_id,
            'gudang_id'=>$data->gudang_id,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_barang,
            'ppn'=>$data->ppn,
            'biaya_lain'=>$data->biaya_lain,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);

        // store stock masuk
        // return object stock masuk
        $stockMasuk = $penjualanRetur->stockMasukMorph()->create([
            'kode'=>$kode,
            'active_cash'=>session('ClosedCash'),
            'nomor_surat_jalan'=>$kode,
            'kondisi'=>$data->kondisi,
            'gudang_id'=>$data->gudang_id,
            'tgl_masuk'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        // store detail
        return $this->storeDetail($data, $penjualanRetur, $stockMasuk);
    }

    public function update($data)
    {
        // initiate
        $penjualanRetur = PenjualanRetur::query()->find($data->penjualan_retur_id);
        $stockMasuk = $penjualanRetur->stockMasukMorph()->first();

        // rollback
        foreach ($penjualanRetur->returDetail as $row)
        {
            (new StockInventoryRepo())->rollback($row, $stockMasuk->gudang_id, $stockMasuk->kondisi, 'stock_masuk');
        }
        // delete retur and stock masuk detail
        $penjualanRetur->returDetail()->delete();
        $stockMasuk->stockMasukDetail()->delete();

        $penjualanRetur->update([
            'customer_id'=>$data->customer_id,
            'gudang_id'=>$data->customer_id,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_bayar,
            'ppn'=>$data->ppn,
            'biaya_lain'=>$data->biaya_lain,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);

        $stockMasuk->update([
            'kondisi'=>'baik',
            'gudang_id'=>$data->gudang_id,
            'tgl_masuk'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        // store detail
        return $this->storeDetail($data, $penjualanRetur, $stockMasuk);
    }

    /**
     * @param $data
     * @param Model|array|null $penjualanRetur
     * @param $stockMasuk
     * @return mixed
     */
    protected function storeDetail($data, Model|array|null $penjualanRetur, $stockMasuk): mixed
    {
        foreach ($data->data_detail as $item) {
            $penjualanRetur->returDetail()->create([
                'produk_id' => $item['produk_id'],
                'harga' => $item['harga'],
                'jumlah' => $item['jumlah'],
                'diskon' => $item['diskon'],
                'sub_total' => $item['sub_total'],
            ]);

            $stockMasuk->stockMasukDetail()->create([
                'produk_id' => $item['produk_id'],
                'jumlah' => $item['jumlah'],
            ]);
            (new StockInventoryRepo())->incrementArrayData($item, $data->gudang_id, $data->kondisi, 'stock_masuk');
        }
        return $penjualanRetur->id;
    }

    public function destroy($penjualan_retur_id)
    {
        $penjualanRetur = PenjualanRetur::query()->find($penjualan_retur_id);
        $stockMasuk = $penjualanRetur->stockMasukMorph()->first();

        // rollback
        foreach ($penjualanRetur->returDetail as $row)
        {
            (new StockInventoryRepo())->rollback($row, $stockMasuk->gudang_id, $stockMasuk->kondisi, 'stock_masuk');
        }

        $penjualanRetur->returDetail()->delete();
        $stockMasuk->stockMasukDetail()->delete();
        $stockMasuk->delete();
        $penjualanRetur->delete();
    }
}
