<?php namespace App\Haramain\Repository\Sales;

use App\Models\Penjualan\Penjualan;

class PenjualanRepo
{
    public function kode()
    {
        //
    }

    public function store()
    {
        $penjualan = Penjualan::query()->create();

        $stock_keluar = $penjualan->stockKeluarMorph();
    }
}
