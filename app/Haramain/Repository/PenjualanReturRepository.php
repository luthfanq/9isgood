<?php namespace App\Haramain\Repository;

use App\Models\Sales\PenjualanRetur;

class PenjualanReturRepository
{
    public function kode(): ?string
    {
        return null;
    }

    public function create(object $data, array $detail)
    {
        $penjualanRetur = PenjualanRetur::query()->create([
            'kode'=>$this->kode(),
            'active_cash'=>session('ClosedCash'),
            'jenis_retur'=>$data->jenis_retur,
            'customer_id'=>$data->customer,
            'gudang_id'=>$data->gudang,
            'user_id'=>\Auth::id(),
            'tgl_nota'=>$data->tgl_nota,
            'tgl_tempo'=>($data->jenis_bayar == 'tempo') ? $data->tgl_tempo : null,
            'status_bayar'=>$data->status_bayar,
            'total_barang'=>$data->total_barang,
            'ppn'=>$data->ppn,
            'biaya_lain'=>$data->biaya_lain,
            'total_bayar'=>$data->total_bayar,
            'keterangan'=>$data->keterangan,
        ]);
    }
}
