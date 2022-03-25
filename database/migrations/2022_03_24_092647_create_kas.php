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
        Schema::dropIfExists('kas');
        Schema::connection('mysql2')->create('kas', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('active_cash');
            $table->enum('type', ['debet', 'kredit']);
            $table->string('jurnal_type')->nullable();
            $table->unsignedBigInteger('jurnal_id')->nullable();
            $table->unsignedBigInteger('akun_id');
            $table->bigInteger('nominal_debet');
            $table->bigInteger('nominal_kredit');
            $table->bigInteger('nominal_saldo');
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
        Schema::connection('mysql2')->dropIfExists('kas');
    }
};
