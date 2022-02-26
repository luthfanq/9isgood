<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockKeluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('active_cash');
            $table->unsignedInteger('stockable_keluar_id')->nullable();
            $table->string('stockable_keluar_type')->nullable();
            $table->string('kondisi'); // baik atau rusak
            $table->foreignId('gudang_id')
                ->constrained('gudang')
                ->cascadeOnUpdate();
            $table->date('tgl_keluar');
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
        Schema::dropIfExists('stock_keluar');
    }
}
