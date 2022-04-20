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
        Schema::connection('mysql2')->create('jurnal_persediaan_mutasi', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash');
            $table->string('kode');
            $table->unsignedBigInteger('gudang_asal_id');
            $table->unsignedBigInteger('gudang_tujuan_id');
            $table->unsignedBigInteger('stock_mutasi_id');
            $table->enum('jenis', ['baik_baik', 'baik_rusak', 'rusak_rusak']);
            $table->unsignedBigInteger('user_id');
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
        Schema::connection('mysql2')->dropIfExists('jurnal_persediaan_mutasi');
    }
};
