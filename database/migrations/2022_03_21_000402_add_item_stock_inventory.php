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
        Schema::table('stock_inventory', function (Blueprint $table) {
            $table->bigInteger('stock_akhir')->nullable()->default(0)->after('stock_keluar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_inventory', function (Blueprint $table) {
            $table->dropColumn('stock_akhir');
        });
    }
};
