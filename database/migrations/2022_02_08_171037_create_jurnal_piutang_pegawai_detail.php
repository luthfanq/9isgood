<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalPiutangPegawaiDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_piutang_pegawai_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jurnal_piutang_pegawai_id');
            $table->bigInteger('nominal_debet');
            $table->bigInteger('nominal_kredit');
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
        Schema::dropIfExists('jurnal_piutang_pegawai_detail');
    }
}
