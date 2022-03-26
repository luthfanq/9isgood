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
        Schema::connection('mysql2')->create('persediaan_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash');
            $table->string('kode');
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->string('persediaan_type')->nullable();
            $table->unsignedBigInteger('persediaan_id')->nullable();
            $table->bigInteger('debet')->nullable();
            $table->bigInteger('kredit')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('persediaan_transaksi');
    }
};
