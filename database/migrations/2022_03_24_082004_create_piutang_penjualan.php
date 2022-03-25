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
        Schema::connection('mysql2')->create('piutang_penjualan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('saldo_piutang_penjualan_id');
            $table->unsignedBigInteger('penjualan_id');
            $table->enum('status_bayar', ['lunas', 'belum', 'kurang']);
            $table->bigInteger('kurang_bayar')->nullable()->default(0);
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
        Schema::connection('mysql2')->dropIfExists('piutang_penjualan');
    }
};
