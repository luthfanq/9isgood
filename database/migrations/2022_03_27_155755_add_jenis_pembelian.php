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
        Schema::table('pembelian', function (Blueprint $table) {
            $table->enum('jenis', ['INTERNAL', 'BLU'])->after('kode');
        });
        Schema::table('pembelian_retur', function (Blueprint $table) {
            $table->enum('jenis', ['INTERNAL', 'BLU'])->after('kode');
            $table->enum('kondisi', ['baik', 'rusak'])->after('jenis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pembelian', function (Blueprint $table) {
            $table->dropColumn('jenis');
        });
        Schema::table('pembelian_retur', function (Blueprint $table) {
            $table->dropColumn(['jenis', 'kondisi']);
        });
    }
};
