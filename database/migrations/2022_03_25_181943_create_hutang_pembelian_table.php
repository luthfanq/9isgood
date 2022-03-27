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
        Schema::connection('mysql2')->create('hutang_pembelian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('saldo_hutang_pembelian_id');
            $table->unsignedBigInteger('pembelian_id');
            $table->enum('status_bayar', ['lunas', 'belum', 'kurang']);
            $table->bigInteger('total_bayar');
            $table->bigInteger('kurang_bayar');
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
        Schema::connection('mysql2')->dropIfExists('hutang_pembelian');
    }
};
