<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockPreorderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_preorder_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_preorder_id')
                ->constrained('stock_preorder')
                ->cascadeOnUpdate();
            $table->foreignId('produk_id')
                ->constrained('produk')
                ->cascadeOnUpdate();
            $table->bigInteger('jumlah');
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
        Schema::dropIfExists('stock_preorder_detail');
    }
}
