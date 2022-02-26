<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOpnameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_opname', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash');
            $table->string('kode');
            $table->string('jenis');
            $table->date('tgl_input');
            $table->foreignId('gudang_id')
                ->constrained('gudang')
                ->cascadeOnUpdate();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate();
            $table->unsignedInteger('pegawai_id')->nullable();
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
        Schema::dropIfExists('stock_opname');
    }
}
