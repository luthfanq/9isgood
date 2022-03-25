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
        if (Schema::hasTable('saldo_piutang_penjualan')){
            Schema::dropIfExists('saldo_piutang_penjualan');
        }
        Schema::connection('mysql2')->create('saldo_piutang_penjualan', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->primary();
            $table->bigInteger('saldo');
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
        if (Schema::connection('mysql2')->hasTable('saldo_piutang_penjualan')){
            Schema::connection('mysql2')->dropIfExists('saldo_piutang_penjualan');
        }
    }
};
