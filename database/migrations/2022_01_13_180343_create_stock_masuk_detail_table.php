<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMasukDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_masuk_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_masuk_id')
                ->constrained('stock_masuk')
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
        Schema::dropIfExists('stock_masuk_detail');
    }
}
