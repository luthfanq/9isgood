<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkun extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akun', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('akun_kategori_id');
            $table->foreignId('akun_tipe_id')
                ->constrained('akun_tipe')
                ->cascadeOnUpdate();
            $table->string('kode');
            $table->string('deskripsi');
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
        Schema::dropIfExists('akun');
    }
}
