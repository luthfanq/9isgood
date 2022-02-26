<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')
                ->nullable()
                ->constrained('produk_kategori')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('kategori_harga_id')
                ->nullable()
                ->constrained('produk_kategori_harga')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('kode');
            $table->string('kode_lokal')->nullable();
            $table->string('penerbit')->nullable();
            $table->string('nama');
            $table->unsignedInteger('hal')->nullable();
            $table->string('cover')->nullable();
            $table->bigInteger('harga');
            $table->string('size')->nullable();
            $table->text('deskripsi')->nullable();
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
        Schema::dropIfExists('produk');
    }
}
