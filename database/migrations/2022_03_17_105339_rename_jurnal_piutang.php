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
        Schema::table('jurnal_piutang_penjualan_table', function (Blueprint $table) {
            $table->rename('jurnal_piutang_penjualan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jurnal_piutang_penjualan_table', function (Blueprint $table) {
            $table->rename('jurnal_piutang_penjualan_table');
        });
    }
};
