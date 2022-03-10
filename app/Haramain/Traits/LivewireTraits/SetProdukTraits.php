<?php namespace App\Haramain\Traits\LivewireTraits;

use App\Models\Master\Produk;

trait SetProdukTraits
{
    public $idProduk, $namaProduk, $kodeLokalProduk, $halProduk, $coverProduk;

    public function setProduk_sales(Produk $produk): Produk
    {
        $this->idProduk = $produk->id;
        $this->namaProduk = $produk->nama."\n".$produk->cover."\n".$produk->hal;
        $this->kodeLokalProduk = $produk->kode_lokal;
        $this->halProduk = $produk->hal;
        $this->coverProduk = $produk->cover;
        return $produk;
    }
}
