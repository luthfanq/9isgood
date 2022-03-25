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
        if (Schema::hasTable('jurnal_transaksi'))
        {
            Schema::dropIfExists('jurnal_transaksi');
        }

        Schema::connection('mysql2')->create('jurnal_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash');
            $table->string('jurnal_type')->nullable();
            $table->unsignedBigInteger('jurnal_id')->nullable();
            $table->unsignedBigInteger('akun_id');
            $table->bigInteger('nominal_debet')->nullable();
            $table->bigInteger('nominal_kredit')->nullable();
            $table->text('keterangan');
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
        Schema::connection('mysql2')->dropIfExists('jurnal_transaksi');
    }
};
