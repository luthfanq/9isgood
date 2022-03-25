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
        if (Schema::hasTable('jurnal_penjualan'))
        {
            Schema::dropIfExists('jurnal_penjualan_detail');
            Schema::dropIfExists('jurnal_penjualan');
        }
        Schema::connection('mysql2')->create('jurnal_penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('active_cash');
            $table->unsignedBigInteger('penjualan_id');
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
        Schema::connection('mysql2')->dropIfExists('jurnal_penjualan');
    }
};
