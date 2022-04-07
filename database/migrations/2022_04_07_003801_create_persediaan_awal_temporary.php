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
        Schema::connection('mysql2')->create('persediaan_awal_temporary', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash');
            $table->unsignedBigInteger('gudang_id');
            $table->enum('kondisi', ['baik','rusak']);
            $table->unsignedBigInteger('produk_id');
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
        Schema::connection('mysql2')->dropIfExists('persediaan_awal_temporary');
    }
};
