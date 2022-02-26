<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKeteranganToTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jurnal_transaksi', function (Blueprint $table) {
            $table->string('keterangan')->nullable()->after('nominal_kredit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jurnal_transaksi', function (Blueprint $table) {
            $table->dropIfExists('keterangan');
        });
    }
}
