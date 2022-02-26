<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNominalSaldoToDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jurnal_piutang_pegawai_detail', function (Blueprint $table) {
            $table->bigInteger('nominal_debet')->nullable()->default(0)->change();
            $table->bigInteger('nominal_kredit')->nullable()->default(0)->change();
            $table->bigInteger('nominal_saldo')->nullable()->default(0)->after('nominal_kredit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jurnal_piutang_pegawai_detail', function (Blueprint $table) {
            $table->dropColumn('nominal_saldo');
        });
    }
}
