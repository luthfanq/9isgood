<?php namespace App\Haramain\Repository\StockMasuk;

use App\Haramain\Repository\StockInventoryRepository;

trait StockMasukRepoTrait
{
    /**
     * simpan Stock Masuk
     * update Stock Inventory
     * @param object $stock_masuk
     * @param object $data
     * @param array $detail
     * @param string $kondisi
     * @return object|null
     */
    public static function storeStockMasuk(object $stock_masuk, object $data, array $detail, string $kondisi):? object
    {
        $stock_masuk = $stock_masuk->create([
            'kode'=>StockMasukRepository::kode('baik'),
            'active_cash'=>session('ClosedCash'),
            'kondisi'=>'baik',
            'gudang_id'=>$data->gudang_id,
            'nomor_surat_jalan'=>$data->surat_jalan,
            'tgl_masuk'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        $stock_masuk_detail = $stock_masuk->stockMasukDetail();

        foreach ($detail as $row){

            $stock_masuk_detail->create([
                'produk_id'=>$row['produk_id'],
                'jumlah'=>$row['jumlah'],
            ]);

            StockInventoryRepository::create(
                (object)[
                    'produk_id' => $row['produk_id'],
                    'jumlah' => $row['jumlah']
                ],
                $kondisi,
                $data->gudang_id,
                'stock_masuk'
            );
        }

        return $stock_masuk;
    }

    public static function storeStockMasukDetail (object $stock_masuk, $row, $gudang, $kondisi, $field_inventory)
    {
        $stock_masuk->stockMasukDetail()->create([
            'produk_id'=>$row['produk_id'],
            'jumlah'=>$row['jumlah'],
        ]);
        StockInventoryRepository::create(
            (object)[
                'produk_id' => $row['produk_id'],
                'jumlah' => $row['jumlah']
            ],
            $kondisi,
            $gudang,
            $field_inventory
        );
    }

    public static function updateStockMasuk(object $stock_masuk,object $data, $kondisi)
    {
        $stock_masuk->update([
            'nomor_surat_jalan'=>$data->surat_jalan,
            'kondisi'=>$kondisi,
            'gudang_id'=>$data->gudang_id,
            'tgl_masuk'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);
    }
}
