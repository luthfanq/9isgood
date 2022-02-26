<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasirPenjualanDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kasir_penjualan_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kasir_penjualan_id');
            $table->unsignedBigInteger('penjualan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kasir_penjualan_detail');
    }
}
