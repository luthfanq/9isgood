<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTglPenerimaanToJurnalPenerimaanPenjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jurnal_penerimaan_penjualan', function (Blueprint $table) {
            $table->date('tgl_penerimaan')->after('kode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jurnal_penerimaaan_penjualan', function (Blueprint $table) {
            //
        });
    }
}
