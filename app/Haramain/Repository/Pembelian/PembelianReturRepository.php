<?php namespace App\Haramain\Repository\Pembelian;

use App\Haramain\Repository\PersediaanPerpetualRepo;
use App\Haramain\Repository\PersediaanTransaksiRepo;
use App\Haramain\Repository\StockInventoryRepository;
use App\Haramain\Repository\StockKeluarRepository;
use App\Haramain\Repository\TransaksiRepositoryInterface;
use App\Models\Keuangan\HutangPembelian;
use App\Models\Purchase\PembelianRetur;

class PembelianReturRepository implements TransaksiRepositoryInterface
{

    public static function kode(): ?string
    {
        // query
        $query = PembelianRetur::query()
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');

        // check last num
        if ($query->doesntExist()) {
            return '0001/PBR/' . date('Y');
        }

        $num = (int)$query->first()->last_num_trans + 1 ;
        return sprintf("%04s", $num) . "/PBR/" . date('Y');
    }

    public static function create(object $data, array $detail): ?string
    {
        $pembelianRetur = PembelianRetur::query()->create([
            'kode'=>self::kode(),
            'active_cash'=>session('ClosedCash'),
            'jenis'=>$data->jenis,
            'kondisi'=>$data->kondisi,
            'supplier_id'=>$data->supplier_id,
            'gudang_id'=>$data->gudang_id,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'tgl_tempo'=>($data->jenis_bayar == 'tempo') ? tanggalan_database_format($data->tgl_tempo, 'd-M-Y') : null,
            'jenis_bayar'=>$data->jenis_bayar,
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_barang,
            'ppn'=>$data->ppn,
            'biaya_lain'=>$data->biaya_lain,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);

        $pembelian_bersih = $data->total_bayar - (int)$data->biaya_lain - (int)$data->ppn;

        $stock_keluar = $pembelianRetur->stockKeluarMorph()->create([
            'kode'=>StockKeluarRepository::kode('baik'),
            'active_cash'=>session('ClosedCash'),
            'kondisi'=>'baik',
            'gudang_id'=>$data->gudang_id,
            'tgl_keluar'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan
        ]);

        $persediaan_keluar = $pembelianRetur->persediaan_transaksi()->create([
            'active_cash'=>session('ClosedCash'),
            'kode'=>PersediaanTransaksiRepo::kode(),
            'jenis'=>'keluar', // masuk atau keluar
            'debet'=>null,
            'kredit'=>$pembelian_bersih,
        ]);

        // jurnal transaksi
        $jurnal_transaksi = $pembelianRetur->jurnal_transaksi();

        // jurnal transaksi debet
        $jurnal_transaksi->create([
            'active_cash'=>session('ClosedCash'),
            'akun_id'=>$data->akun_hutang_dagang, // konfig hutang dagang
            'nominal_debet'=>$data->total_bayar,
        ]);

        // jurnal transaksi kredit
        return self::jurnalTransaksiKredit($jurnal_transaksi, $data, $pembelian_bersih, $detail, $pembelianRetur, $stock_keluar, $persediaan_keluar);
    }

    public static function update(object $data, array $detail): ?string
    {
        $pembelianRetur = PembelianRetur::query()
            ->find($data->pembelian_id);

        // rollback
        foreach ($pembelianRetur->returDetail as $row)
        {
            StockInventoryRepository::rollback($row, 'baik', $pembelianRetur->gudang_id, 'stock_keluar');
            // rollback persediaan_perpetual
            PersediaanPerpetualRepo::rollback($row, 'masuk', $pembelianRetur->gudang_id, $data->kondisi);
        }

        $pembelianRetur->returDetail()->delete();

        $pembelianRetur->update([
            'supplier_id'=>$data->supplier_id,
            'gudang_id'=>$data->gudang_id,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'tgl_tempo'=>($data->jenis_bayar == 'tempo') ? tanggalan_database_format($data->tgl_tempo, 'd-M-Y') : null,
            'jenis_bayar'=>$data->jenis_bayar,
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_barang,
            'ppn'=>$data->ppn,
            'biaya_lain'=>$data->biaya_lain,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);

        $stock_keluar = $pembelianRetur->stockKeluarMorph()->first();

        $stock_keluar->stockKeluarDetail()->delete();

        $stock_keluar->update([
            'kondisi'=>'baik',
            'gudang_id'=>$data->gudang_id,
            'tgl_keluar'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        $pembelian_bersih = $data->total_bayar - (int)$data->biaya_lain - (int)$data->ppn;

        $persediaan_keluar = $pembelianRetur->persediaan_transaksi();
        $persediaan_keluar->persediaan_transaksi_detail()->delete();
        $persediaan_keluar->update([
            'kredit'=>$pembelian_bersih,
        ]);

        // rollback saldo_hutang_penjualan
        HutangPembelianRepo::rollback($pembelianRetur->supplier_id, 0 - $pembelianRetur->total_bayar);

        $hutangPembelian = $pembelianRetur->hutang_pembelian()->first();
        $hutangPembelian->update([
            'total_bayar'=> 0 - $data->total_bayar
        ]);

        HutangPembelian::query()
            ->where('customer_id', $data->customer_id)
            ->decrement('saldo', $data->total_bayar);

        $jurnal_transaksi = $pembelianRetur->jurnal_transaksi()->delete();
        // jurnal transaksi kredit
        return self::jurnalTransaksiKredit($jurnal_transaksi, $data, $pembelian_bersih, $detail, $pembelianRetur, $stock_keluar, $persediaan_keluar);
    }

    public static function detailProses(array $detail, PembelianRetur $pembelianRetur, $stock_keluar, $persediaan_keluar, $kondisi, object $data)
    {
        foreach ($detail as $item)
        {
            $pembelianRetur->returDetail()->create([
                'produk_id' => $item['produk_id'],
                'harga' => $item['harga'],
                'jumlah' => $item['jumlah'],
                'diskon' => $item['diskon'],
                'sub_total' => $item['sub_total'],
            ]);

            $stock_keluar->stockKeluarDetail()->create([
                'produk_id' => $item['produk_id'],
                'jumlah' => $item['jumlah'],
            ]);

            StockInventoryRepository::create(
                (object)[
                    'produk_id' => $item['produk_id'],
                    'jumlah' => $item['jumlah']
                ],
                $kondisi,
                $data->gudang_id,
                'stock_keluar'
            );

            $persediaan_keluar->persediaan_transaksi_detail()->create([
                'produk_id'=>$item['produk_id'],
                'harga'=>$item['harga_setelah_diskon'],
                'jumlah'=>$item['jumlah'],
                'sub_total'=>$item['harga_setelah_diskon'] * $item['jumlah'],
            ]);
            PersediaanPerpetualRepo::store($item, 'keluar', $data->gudang_id, $kondisi);
        }
        return $pembelianRetur->id;
    }

    public static function delete(int $id): ?string
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param $jurnal_transaksi
     * @param object $data
     * @param int $pembelian_bersih
     * @param array $detail
     * @param \Illuminate\Database\Eloquent\Model|array|null $pembelianRetur
     * @param $stock_keluar
     * @param $persediaan_keluar
     * @return mixed
     */
    protected static function jurnalTransaksiKredit($jurnal_transaksi, object $data, int $pembelian_bersih, array $detail, \Illuminate\Database\Eloquent\Model|array|null $pembelianRetur, $stock_keluar, $persediaan_keluar): mixed
    {
        $jurnal_transaksi->create([
            'active_cash' => session('ClosedCash'),
            'akun_id' => $data->akun_persediaan, // konfig persediaan
            'nominal_kredit' => $pembelian_bersih,
        ]);

        if ($data->biaya_lain) {
            $jurnal_transaksi->create([
                'active_cash' => session('ClosedCash'),
                'akun_id' => $data->akun_biaya_lain, // konfig biaya_lain pembelian
                'nominal_kredit' => $data->biaya_lain,
            ]);
        }

        if ($data->ppn) {
            $jurnal_transaksi->create([
                'active_cash' => session('ClosedCash'),
                'akun_id' => $data->akun_ppn, // konfig biaya_ppn pembelian
                'nominal_kredit' => $data->ppn,
            ]);
        }

        return self::detailProses($detail, $pembelianRetur, $stock_keluar, $persediaan_keluar, 'baik', $data);
    }
}
