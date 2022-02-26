<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockInventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_inventory', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash');
            $table->string('jenis'); // baik atau rusak
            $table->foreignId('gudang_id')
                ->constrained('gudang')
                ->cascadeOnUpdate();
            $table->foreignId('produk_id')
                ->constrained('produk')
                ->cascadeOnUpdate();
            $table->bigInteger('stock_awal')->default(0)->nullable();
            $table->bigInteger('stock_opname')->default(0)->nullable();
            $table->bigInteger('stock_masuk')->default(0)->nullable();
            $table->bigInteger('stock_keluar')->default(0)->nullable();
            $table->bigInteger('stock_lost')->default(0)->nullable();
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
        Schema::dropIfExists('stock_inventory');
    }
}
