<?php namespace App\Haramain\Repository\Pembelian;

use App\Haramain\Repository\Persediaan\PersediaanRepository;
use App\Haramain\Repository\Saldo\SaldoHutangPembelianRepository;
use App\Haramain\Repository\Stock\StockInventoryRepo;
use App\Models\Purchase\Pembelian;

trait PembelianRepoTrait
{
    /**
     * @param $data
     * @param \Illuminate\Database\Eloquent\Model|array|null $pembelian
     * @param $stockMasuk
     * @return mixed
     */
    protected function storeDetail($data, \Illuminate\Database\Eloquent\Model|array|null $pembelian, $stockMasuk): mixed
    {
        foreach ($data->data_detail as $item) {
            // pembelian detail
            $pembelian->pembelianDetail()->create([
                'produk_id' => $item['produk_id'],
                'harga' => $item['harga'],
                'jumlah' => $item['jumlah'],
                'diskon' => $item['diskon'] ?? 0,
                'sub_total' => $item['sub_total'],
            ]);

            // stock masuk detail
            $stockMasuk->stockMasukDetail()->create([
                'produk_id' => $item['produk_id'],
                'jumlah' => $item['jumlah']
            ]);

            // stock inventory
            (new StockInventoryRepo())->incrementArrayData($item, $data->gudang_id, 'baik', 'stock_masuk');

            // persediaan
            (new PersediaanRepository())->update($data, $item, 'stock_masuk');
        }

        // simpan atau update hutang pembelian
        $saldoHutangPembelian = (new SaldoHutangPembelianRepository())->find($data->supplier_id);
        $hutangPembelian = $pembelian->hutang_pembelian()->create([
            'saldo_hutang_pembelian_id' => $data->supplier_id,
            'status_bayar' => 'belum', // lunas, belum, kurang
            'total_bayar' => $data->total_bayar,
            'kurang_bayar' => $data->total_bayar,
        ]);
        $saldoHutangPembelian->increment('saldo', $data->total_bayar);

        // jurnal transaksi
        $jurnalTransaksi = $pembelian->jurnal_transaksi();

        $persediaan = ($pembelian->gudang->nama == 'kalimas') ? $data->persediaan_kalimas : $data->persediaan_perak;

        // debet
        $jurnalTransaksi->create([
            'active_cash' => session('ClosedCash'),
            'akun_id' => $persediaan, // konfig persediaan
            'nominal_debet' => $data->total_bayar,
        ]);

        // kredit
        $jurnalTransaksi->create([
            'active_cash' => session('ClosedCash'),
            'akun_id' => $data->hutang_dagang_internal, // konfig hutang dagang
            'nominal_kredit' => $data->total_bayar,
        ]);
        return $pembelian->id;
    }

    public function destroy($pembelian_id)
    {
        // initiate
        $pembelian = Pembelian::query()->find($pembelian_id);
        $stockMasuk = $this->rollback($pembelian);

        // delete stock masuk
        $stockMasuk->delete();

        return $pembelian->delete();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model|array|null $pembelian
     * @return mixed
     */
    protected function rollback(\Illuminate\Database\Eloquent\Model|array|null $pembelian): mixed
    {
        $stockMasuk = $pembelian->stockMasukMorph()->first();
        $jurnalTransaksi = $pembelian->jurnal_transaksi();
        $saldoHutangPembelian = (new SaldoHutangPembelianRepository())->find($pembelian->supplier_id);

        /**
         * rollback
         */
        foreach ($pembelian->pembelianDetail as $item) {
            // stock inventory
            (new StockInventoryRepo())->rollback($item, $pembelian->gudang_id, 'baik', 'stock_masuk');

            // persediaan
            (new PersediaanRepository())->rollbackObject($pembelian, $item, 'stock_masuk', 'baik');
        }
        // rollback saldo hutang
        $saldoHutangPembelian->decrement('saldo', $pembelian->total_bayar);

        // delete stock masuk detail
        $stockMasuk->stockMasukDetail()->delete();

        // delete pembelian detail
        $pembelian->pembelianDetail()->delete();

        // delete jurnal
        $jurnalTransaksi->delete();
        return $stockMasuk;
    }
}
