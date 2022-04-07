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
        Schema::connection('mysql2')->table('hutang_pembelian', function (Blueprint $table) {
            $table->string('pembelian_type')->after('saldo_hutang_pembelian_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->table('hutang_pembelian', function (Blueprint $table) {
            $table->dropColumn('pembelian_type');
        });
    }
};
