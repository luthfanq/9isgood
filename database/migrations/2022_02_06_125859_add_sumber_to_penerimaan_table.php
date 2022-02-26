<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSumberToPenerimaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jurnal_penerimaan', function (Blueprint $table) {
            $table->string('sumber')->nullable()->after('tgl_penerimaan');
        });

        Schema::table('jurnal_pengeluaran', function (Blueprint $table){
            $table->string('asal')->nullable()->after('tgl_pengeluaran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jurnal_penerimaan', function (Blueprint $table) {
            $table->dropColumn('sumber');
        });
        Schema::table('jurnal_pengeluaran', function (Blueprint $table) {
            $table->dropColumn('asal');
        });
    }
}
