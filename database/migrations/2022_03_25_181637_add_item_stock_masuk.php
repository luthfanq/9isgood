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
        Schema::table('stock_masuk', function (Blueprint $table) {
            $table->string('nomor_surat_jalan')->after('active_cash');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_masuk', function (Blueprint $table) {
            $table->dropColumn('nomor_surat_jalan');
        });
    }
};
