<?php

namespace App\Haramaian\Repository;

use App\Models\Sales\Penjualan;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PenjualanRepository
{
    public function kode()
    {
        //
    }

    public function store($data): ?string
    {
                // create penjualan
        // return object penjualan
        $penjualan = Penjualan::query()->create($data);

        // create stock_masuk jenis baik
        // detail proses
        return null;
    }
}
