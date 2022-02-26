<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('jurnal_type');
            $table->unsignedBigInteger('jurnal_id');
            $table->unsignedBigInteger('akun_id');
            $table->bigInteger('nominal_debet')->nullable()->default(0);
            $table->bigInteger('nominal_kredit')->nullable()->default(0);
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
        Schema::dropIfExists('jurnal_transaksi');
    }
}
