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
        Schema::connection('mysql2')->create('piutang_penjualan_lama_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('piutang_penjualan_lama_id');
            $table->string('penjualan_id');
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
        Schema::connection('mysql2')->dropIfExists('piutang_penjualan_lama_detail');
    }
};
