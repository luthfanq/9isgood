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
        Schema::table('jurnal_penjualan', function (Blueprint $table) {
            $table->bigInteger('total_penjualan')->after('kode');
            $table->bigInteger('total_biaya_lain')->nullable()->after('total_penjualan');
            $table->bigInteger('total_hutang_ppn')->after('total_biaya_lain');

            $table->bigInteger('total_kas')->after('total_bayar')->nullable();
            $table->bigInteger('total_piutang')->after('total_kas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jurnal_penjualan', function (Blueprint $table) {
            $table->dropColumn(['total_penjualan', 'total_biaya_lain', 'total_hutang_ppn', 'total_kas', 'total_piutang']);
        });
    }
};
