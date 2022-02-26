<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanBiayaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_biaya', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_id')
                ->constrained('penjualan');
            $table->unsignedBigInteger('akun_id');
            $table->bigInteger('nominal');
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
        Schema::dropIfExists('penjualan_biaya');
    }
}
