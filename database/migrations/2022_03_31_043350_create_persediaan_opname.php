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
        Schema::dropIfExists('persediaan_opname');
        Schema::connection('mysql2')->create('persediaan_opname', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('active_cash');
            $table->enum('kondisi', ['baik', 'rusak']);
            $table->unsignedBigInteger('gudang_id');
            $table->unsignedBigInteger('stock_opname_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('persediaan_opname');
    }
};
