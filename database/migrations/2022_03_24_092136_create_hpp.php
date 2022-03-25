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
        Schema::connection('mysql2')->create('hpp', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash');
            $table->enum('type', ['debet', 'kredit']);
            $table->string('stock_type')->nullable();
            $table->unsignedBigInteger('stock_id')->nullable();
            $table->bigInteger('nominal_debet')->nullable();
            $table->bigInteger('nominal_kredit')->nullable();
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
        Schema::connection('mysql2')->dropIfExists('hpp');
    }
};
