<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockPreorderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_preorder', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('active_cash');
            $table->date('tgl_preorder');
            $table->date('tgl_selesai');
            $table->string('status');
            $table->unsignedBigInteger('supplier_id');
            $table->foreignId('user_id');
            $table->bigInteger('total_barang');
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
        Schema::dropIfExists('stock_preorder');
    }
}
