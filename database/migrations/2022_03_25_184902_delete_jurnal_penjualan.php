<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->dropIfExists('jurnal_penjualan');
        Schema::connection('mysql2')->dropIfExists('jurnal_pembelian');
        Schema::dropIfExists('jurnal_penjualan_detail');
        Schema::dropIfExists('jurnal_penjualan');
        Schema::dropIfExists('jurnal_pembelian_detail');
        Schema::dropIfExists('jurnal_pembelian');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
