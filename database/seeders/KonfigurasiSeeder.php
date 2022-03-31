<?php

namespace Database\Seeders;

use App\Models\KonfigurasiJurnal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KonfigurasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KonfigurasiJurnal::query()->insertOrIgnore([
            ['config'=>'biaya_pembelian'],
            ['config'=>'hutang_dagang'],
            ['config'=>'hutang_dagang_internal'],
            ['config'=>'ppn_pembelian'],
            ['config'=>'biaya_penjualan'],
            ['config'=>'piutang_usaha'],
            ['config'=>'ppn_penjualan'],
            ['config'=>'persediaan_baik'],
            ['config'=>'persediaan_rusak'],
        ]);
    }
}
