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
        Schema::connection('mysql2')->table('piutang_penjualan', function (Blueprint $table) {
            $table->unsignedBigInteger('jurnal_set_piutang_awal_id')->nullable()->after('saldo_piutang_penjualan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('piutang_penjualan', function (Blueprint $table) {
            $table->dropColumn('jurnal_set_piutang_awal_id');
        });
    }
};
