<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HargaHppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('mysql2')->table('harga_hpp_all')->insertOrIgnore([
            'deskripsi'=>'HPP Internal',
            'harga'=>null,
            'persen'=>null,
        ]);
    }
}
