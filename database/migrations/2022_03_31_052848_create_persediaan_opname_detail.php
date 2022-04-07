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
        Schema::dropIfExists('persediaan_opname_detail');
        Schema::connection('mysql2')->create('persediaan_opname_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('persediaan_opname_id');
            $table->unsignedBigInteger('produk_id');
            $table->bigInteger('jumlah');
            $table->bigInteger('harga');
            $table->bigInteger('sub_total');
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
        Schema::connection('mysql2')->dropIfExists('persediaan_opname_detail');
    }
};
