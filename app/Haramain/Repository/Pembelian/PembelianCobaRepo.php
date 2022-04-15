<?php namespace App\Haramain\Repository\Pembelian;

use App\Haramain\Repository\Stock\StockMasukRepo;
use App\Models\Purchase\Pembelian;

class PembelianCobaRepo
{
    public function store($data)
    {
        $pembelian = Pembelian::query()->create([
            'kode'=>(new PembelianInternalRepo())->kode(),
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
        return $pembelian;
    }
}
