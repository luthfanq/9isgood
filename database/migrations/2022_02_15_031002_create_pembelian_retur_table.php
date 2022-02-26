<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianReturTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian_retur', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('active_cash');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('gudang_id');
            $table->unsignedBigInteger('user_id');
            $table->date('tgl_nota');
            $table->date('tgl_tempo')->nullable();
            $table->string('jenis_bayar');
            $table->string('status_bayar');
            $table->integer('total_barang')->nullable()->default(0);
            $table->bigInteger('ppn')->nullable()->default(0);
            $table->bigInteger('biaya_lain')->nullable()->default(0);
            $table->bigInteger('total_bayar');
            $table->text('keterangan')->nullable();
            $table->integer('print')->nullable();
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
        Schema::dropIfExists('pembelian_retur');
    }
}
