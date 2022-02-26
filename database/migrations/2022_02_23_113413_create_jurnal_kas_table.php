<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalKasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_kas', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('active_cash');
            $table->string('cash_type')->nullable();
            $table->unsignedBigInteger('cash_id')->nullable();
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
        Schema::dropIfExists('jurnal_kas');
    }
}
