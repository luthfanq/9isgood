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
            $table->bigInteger('total_penjualan')->after('customer_id');
            $table->unsignedBigInteger('akun_biaya_lain')->nullable()->after('total_penjualan');
            $table->bigInteger('total_biaya_lain')->nullable()->after('akun_biaya_lain');
            $table->unsignedBigInteger('akun_hutang_ppn')->after('total_biaya_lain');
            $table->bigInteger('total_hutang_ppn')->after('akun_hutang_ppn');
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
            $table->dropColumn(['total_penjualan', 'akun_biaya_lain', 'total_biaya_lain', 'akun_hutang_ppn', 'total_hutang_ppn']);
        });
    }
};
