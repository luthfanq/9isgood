<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNeracaSaldoAwalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nerasa_saldo_awal', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('akun_id');
            $table->bigInteger('nominal_debet')->nullable();
            $table->bigInteger('nominal_kredit')->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('nerasa_saldo_awal');
    }
}
