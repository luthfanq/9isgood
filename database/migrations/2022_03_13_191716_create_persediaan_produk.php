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
        Schema::create('persediaan_produk_internal', function (Blueprint $table) {
            $table->id();
            $table->string('jenis'); // internal atau eksternal
            $table->string('kondisi'); // baik atau rusak
            $table->unsignedBigInteger('gudang_id');
            $table->string('active_cash');
            $table->unsignedBigInteger('produk');
            $table->bigInteger('harga');
            $table->bigInteger('jumlah_awal');
            $table->bigInteger('harga_stock_awal');
            $table->bigInteger('jumlah_masuk');
            $table->bigInteger('harga_stock_masuk');
            $table->bigInteger('jumlah_keluar');
            $table->bigInteger('harga_stock_keluar');
            $table->bigInteger('jumlah_akhir');
            $table->bigInteger('harga_stock_akhir');
            $table->bigInteger('jumlah_lost');
            $table->bigInteger('harga_stock_lost');
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
        Schema::dropIfExists('persediaan_produk_internal');
    }
};
