<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianReturDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian_retur_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pembelian_retur_id');
            $table->unsignedBigInteger('produk_id');
            $table->bigInteger('harga');
            $table->bigInteger('jumlah');
            $table->double('diskon', '255', '2');
            $table->bigInteger('sub_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian_retur_detail');
    }
}
