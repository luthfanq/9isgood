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
        Schema::table('penjualan_detail', function (Blueprint $table) {
            $table->bigInteger('total_penjualan')->after('penjualan_id');
            $table->unsignedBigInteger('akun_biaya_1')->nullable()->after('total_penjualan');
            $table->bigInteger('total_biaya_1')->nullable()->after('akun_biaya_1');
            $table->unsignedBigInteger('akun_biaya_2')->nullable()->after('total_biaya_1');
            $table->bigInteger('total_biaya_2')->nullable()->after('akun_biaya_2');
            $table->unsignedBigInteger('akun_ppn')->nullable()->after('total_biaya_2');
            $table->bigInteger('total_ppn')->nullable()->after('akun_ppn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjualan_detail', function (Blueprint $table) {
            $table->dropColumn(['total_penjualan', 'akun_biaya_1', 'total_biaya_1', 'akun_biaya_2', 'total_biaya_2', 'akun_ppn', 'total_ppn']);
        });
    }
};
