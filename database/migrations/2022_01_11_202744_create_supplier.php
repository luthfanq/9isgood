<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_jenis_id')
                ->nullable()
                ->constrained('supplier')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('nama');
            $table->text('alamat');
            $table->string('telepon')->nullable();
            $table->string('npwp')->nullable();
            $table->string('email')->nullable();
            $table->text('keterangan')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('supplier');
    }
}
