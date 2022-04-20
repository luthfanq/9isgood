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
        Schema::connection('mysql2')->table('persediaan_transaksi', function (Blueprint $table) {
            $table->enum('kondisi', ['baik', 'rusak'])->after('jenis');
            $table->unsignedBigInteger('gudang_id')->after('jenis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('persediaan_transaksi', function (Blueprint $table) {
            $table->dropColumn(['kondisi','gudang_id']);
        });
    }
};
