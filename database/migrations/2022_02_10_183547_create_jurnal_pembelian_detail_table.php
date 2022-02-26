<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalPembelianDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_pembelian_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jurnal_pembelian_id');
            $table->unsignedBigInteger('pembelian_id');
            $table->bigInteger('total_bayar');
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
        Schema::dropIfExists('jurnal_pembelian_detail');
    }
}
