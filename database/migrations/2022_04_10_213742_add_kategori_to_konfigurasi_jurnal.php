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
        Schema::connection('mysql2')->table('konfigurasi_jurnal', function (Blueprint $table) {
            $table->string('kategori')->after('config');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('konfigurasi_jurnal', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};
