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
        Schema::connection('mysql2')->create('persediaan', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash');
            $table->enum('jenis', ['baik', 'rusak']);
            $table->unsignedBigInteger('gudang_id');
            $table->unsignedBigInteger('produk_id');
            $table->bigInteger('harga');
            $table->unsignedBigInteger('stock_opname')->nullable()->default(0);
            $table->unsignedBigInteger('stock_masuk')->nullable()->default(0);
            $table->unsignedBigInteger('stock_keluar')->nullable()->default(0);
            $table->unsignedBigInteger('stock_akhir')->nullable()->default(0);
            $table->unsignedBigInteger('stock_lost')->nullable()->default(0);
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
        Schema::connection('mysql2')->dropIfExists('persediaan');
    }
};
