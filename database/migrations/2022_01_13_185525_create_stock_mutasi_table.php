<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMutasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_mutasi', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash');
            $table->string('kode');
            $table->string('jenis_mutasi');
            $table->unsignedBigInteger('gudang_asal_id');
            $table->unsignedBigInteger('gudang_tujuan_id');
            $table->date('tgl_mutasi');
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate();
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
        Schema::dropIfExists('stock_mutasi');
    }
}
