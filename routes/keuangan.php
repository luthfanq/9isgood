<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function (){

    // master keuangan
    Route::get('keuangan/master/akun', \App\Http\Livewire\Keuangan\Master\AkunIndex::class)->name('keuangan.master.akun');
    Route::get('keuangan/master/akuntipe', \App\Http\Livewire\Keuangan\Master\AkunTipeIndex::class)->name('keuangan.master.akuntipe');
    Route::get('keuangan/master/akunkategori', \App\Http\Livewire\Keuangan\Master\AkunKategoriIndex::class)->name('keuangan.master.akunkategori');
    Route::get('keuangan/master/rekanan', \App\Http\Livewire\Keuangan\Master\RekananIndex::class)->name('keuangan.master.rekanan');

    // config keuangan
    Route::get('keuangan/config/akun', \App\Http\Livewire\KonfigurasiJurnalIndex::class)->name('keuangan.config');
    // payment penjualan
    Route::get('keuangan/kasir/penjualan', \App\Http\Livewire\Keuangan\Kasir\PenerimaanPenjualanIndex::class)->name('keuangan.kasir.penjualan');
    Route::get('keuangan/kasir/penjualan/penerimaan', \App\Http\Livewire\Keuangan\Kasir\PenerimaanPenjualanForm::class)->name('keuangan.kasir.penjualan.penerimaan');
    Route::get('keuangan/kasir/penjualan/penerimaan/{penerimaanPenjualanId}', \App\Http\Livewire\Keuangan\Kasir\PenerimaanPenjualanForm::class);

    // set piutang
    Route::get('keuangan/kasir/penjualan/setpiutang')->name('keuangan.kasir.penjualan.setpiutang');

    Route::get('keuangan/jurnal/piutangpenjualan', \App\Http\Livewire\Keuangan\Kasir\DaftarPiutangPenjualan::class)->name('keuangan.jurnal.piutangpenjualan'); // daftar piutang by customer

    // payment pembelian
    Route::get('keuangan/kasir/pembelian')->name('keuangan.kasir.pembelian');
    Route::get('keuangan/kasir/pembelian/pembayaran')->name('keuangan.kasir.pembelian.pembayaran');

    Route::get('keuangan/kasir/hutangpembelian')->name('keuangan.kasir.hutangpembelian'); // daftar hutang by supplier

    // hutang pegawai
    Route::get('keuangan/kasir/piutanginternal')->name('keuangan.kasir.piutanginternal');
    Route::get('keuangan/kasir/piutanginternal/pembayaran')->name('keuangan.kasir.piutanginternal.pembayaran');
    Route::get('keuangan/kasir/piutanginternal/pembayaran/{id}');
    Route::get('keuangan/kasir/piutanginternal/penerimaan')->name('keuangan.kasir.piutanginternal.penerimaan');
    Route::get('keuangan/kasir/piutanginternal/penerimaan/{id}');

    // penerimaan
    Route::get('keuangan/jurnal/penerimaan')->name('keuangan.jurnal.penerimaan');
    Route::get('keuangan/jurnal/penerimaan/trans')->name('keuangan.jurnal.penerimaan.trans');
    Route::get('keuangan/jurnal/penerimaan/trans/{id}');

    // pengeluaran
    Route::get('keuangan/jurnal/pengeluaran')->name('keuangan.jurnal.pengeluaran');
    Route::get('keuangan/jurnal/pengeluaran/trans')->name('keuangan.jurnal.pengeluaran.trans');
    Route::get('keuangan/jurnal/pengeluaran/trans/{id}');

    // penyesuaian
    Route::get('keuangan/jurnal/penyesuaian')->name('keuangan.jurnal.penyesuaian');
    Route::get('keuangan/jurnal/penyesuaian/trans')->name('keuangan.jurnal.penyesuaian.trans');
    Route::get('keuangan/jurnal/penyesuaian/trans/{id}');

    // neraca
    Route::get('keuangan/neraca')->name('keuangan.neraca');
    Route::get('keuangan/neraca/saldo/awal', \App\Http\Livewire\Keuangan\Kasir\NeracaSaldoAwal::class)->name('keuangan.neraca.saldoawal');

    // persediaan
    Route::get('keuangan/persediaan')->name('keuangan.persediaan');

    // laba-rugi
    Route::get('keuangan/labarugi')->name('keuangan.labarugi');
    Route::get('keuangan/labarugi/{closedcash}')->name('keuangan.labarugi');
});
