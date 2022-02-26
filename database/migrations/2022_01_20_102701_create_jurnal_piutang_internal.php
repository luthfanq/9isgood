<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalPiutangInternal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_piutang_internal', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('tipe');
            $table->unsignedBigInteger('pegawai_id');
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('nominal_debet')->nullable()->default(0);
            $table->bigInteger('nominal_kredit')->nullable()->default(0);
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
        Schema::dropIfExists('jurnal_piutang_internal');
    }
}
