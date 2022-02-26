<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalHutangPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_hutang_pembelian_table', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('active_cash');
            $table->string('hutang_type')->nullable();
            $table->unsignedBigInteger('hutang_id')->nullable();
            $table->unsignedBigInteger('akun_id');
            $table->bigInteger('nominal_debet')->nullable();
            $table->bigInteger('nominal_kredit')->nullable();
            $table->bigInteger('nominal_saldo');
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
        Schema::dropIfExists('jurnal_hutang_pembelian_table');
    }
}
