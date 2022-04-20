<?php namespace App\Haramain\Repository\Pembelian;

use App\Haramain\Repository\Persediaan\PersediaanJenisMasukRepo;
use App\Haramain\Repository\Persediaan\PersediaanRepository;
use App\Haramain\Repository\Saldo\SaldoHutangPembelianRepository;
use App\Haramain\Repository\Stock\StockInventoryRepo;
use App\Haramain\Repository\StockMasuk\StockMasukRepository;
use App\Models\Purchase\Pembelian;

class PembelianInternalRepo
{
    use PembelianRepoTrait;
    public function kode()
    {
        // query
        $query = Pembelian::query()
            ->where('active_cash', session('ClosedCash'))
            ->latest('kode');

        // check last num
        if ($query->doesntExist()) {
            return '0001/PBI/' . date('Y');
        }

        $num = (int)$query->first()->last_num_trans + 1 ;
        return sprintf("%04s", $num) . "/PBI/" . date('Y');
    }

    public function store($data)
    {
        // initiate
        $pembelian = Pembelian::query()->create([
            'kode'=>$this->kode(),
            'active_cash'=>session('ClosedCash'),
            'jenis'=>$data->jenis,
            'nomor_nota'=>$data->nomor_nota,
            'nomor_surat_jalan'=>$data->nomor_surat_jalan,
            'supplier_id'=>$data->supplier_id,
            'gudang_id'=>$data->gudang_id,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'tgl_tempo'=> null,
            'jenis_bayar'=>'internal',
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_barang,
            'ppn'=>null,
            'biaya_lain'=>null,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);

        $stockMasuk = $pembelian->stockMasukMorph()->create(
            [
            'kode'=>StockMasukRepository::kode('baik'),
            'active_cash'=>session('ClosedCash'),
            'kondisi'=>'baik',
            'gudang_id'=>$data->gudang_id,
            'supplier_id'=>$data->supplier_id,
            'nomor_surat_jalan'=>$data->nomor_surat_jalan,
            'tgl_masuk'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
            ]
        );

        // store pembelian detail
        return $this->storeDetail($data, $pembelian, $stockMasuk);
    }

    public function update($data)
    {
        // initiate
        $pembelian = Pembelian::query()->find($data->pembelian_id);
        //dd($pembelian);
        $stockMasuk = $this->rollback($pembelian);

        // pembelian update
        $pembelian->update([
            'nomor_nota'=>$data->nomor_nota,
            'nomor_surat_jalan'=>$data->nomor_surat_jalan,
            'supplier_id'=>$data->supplier_id,
            'gudang_id'=>$data->gudang_id,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'tgl_tempo'=> null,
            'jenis_bayar'=>'internal',
            'status_bayar'=>'belum',
            'total_barang'=>$data->total_barang,
            'ppn'=>null,
            'biaya_lain'=>null,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);

        // stock masuk update
        $stockMasuk->update([
            'gudang_id'=>$data->gudang_id,
            'supplier_id'=>$data->supplier_id,
            'nomor_surat_jalan'=>$data->nomor_surat_jalan,
            'tgl_masuk'=>tanggalan_database_format($data->tgl_nota, 'd-M-Y'),
            'user_id'=>\Auth::id(),
            'keterangan'=>$data->keterangan,
        ]);

        // store pembelian detail
        return $this->storeDetail($data, $pembelian, $stockMasuk);
    }
}
