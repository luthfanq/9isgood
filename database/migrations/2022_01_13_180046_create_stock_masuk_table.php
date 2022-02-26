<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('active_cash');
            $table->unsignedInteger('stockable_masuk_id')->nullable();
            $table->string('stockable_masuk_type')->nullable();
            $table->string('kondisi'); // baik atau rusak
            $table->foreignId('gudang_id')
                ->constrained('gudang')
                ->cascadeOnUpdate();
            $table->date('tgl_masuk');
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate();
            $table->string('nomor_po')->nullable();
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
        Schema::dropIfExists('stock_masuk');
    }
}
