<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard.index');
})->middleware(['auth'])->name('dashboard');

//Route::get('/metronics', function (){
//    return view('pages.dashboard.index');
//});

/**
 * Master Routing
 */
Route::middleware('auth')->group(function (){
    Route::get('/master/produk', \App\Http\Livewire\Master\ProdukIndex::class)->name('produk');
    Route::get('/master/produk/kategori', \App\Http\Livewire\Master\ProdukKategoriIndex::class)->name('produk.kategori');
    Route::get('/master/produk/kategoriharga', \App\Http\Livewire\Master\ProdukKategoriHargaIndex::class)->name('produk.kategoriharga');

    Route::get('/master/gudang', \App\Http\Livewire\Master\GudangIndex::class)->name('gudang');
    Route::get('/master/customer', \App\Http\Livewire\Master\CustomerIndex::class)->name('customer');
    Route::get('/master/supplier', \App\Http\Livewire\Master\SupplierIndex::class)->name('supplier');
    Route::get('/master/supplier/jenis', \App\Http\Livewire\Master\SupplierJenisIndex::class)->name('supplier.jenis');

    Route::get('/master/pegawai', \App\Http\Livewire\Master\PegawaiIndex::class)->name('pegawai');
    Route::get('/master/pegawai/user', \App\Http\Livewire\Master\PegawaiUserIndex::class)->name('pegawai.user');
});

/**
 * Penjualan Routing
 */
Route::middleware('auth')->group(function (){

    // penjualan
    Route::get('penjualan', \App\Http\Livewire\Penjualan\PenjualanIndex::class)->name('penjualan');
    Route::get('penjualan/trans', \App\Http\Livewire\Penjualan\PenjualanForm::class)->name('penjualan.trans');
    Route::get('penjualan/trans/{penjualan}', \App\Http\Livewire\Penjualan\PenjualanForm::class);

    Route::get('penjualan/retur/{kondisi}', \App\Http\Livewire\Penjualan\PenjualanReturIndex::class);
    Route::get('penjualan/retur/{kondisi}/trans', \App\Http\Livewire\Penjualan\PenjualanReturForm::class);
    Route::get('penjualan/retur/{kondisi}/trans/{retur}', \App\Http\Livewire\Penjualan\PenjualanReturForm::class);

});

Route::middleware('auth')->group(function(){

    // pembelian
    Route::get('pembelian', \App\Http\Livewire\Purchase\PembelianIndex::class)->name('pembelian');
    Route::get('pembelian/trans', \App\Http\Livewire\Purchase\PembelianForm::class)->name('pembelian.trans');
    Route::get('pembelian/trans/{pembelian}', \App\Http\Livewire\Purchase\PembelianForm::class);

    Route::get('pembelian/retur/', \App\Http\Livewire\Purchase\PembelianReturIndex::class)->name('pembelian.retur');
    Route::get('pembelian/retur/trans/', \App\Http\Livewire\Purchase\PembelianReturForm::class);
    Route::get('pembelian/retur/trans/{retur}', \App\Http\Livewire\Purchase\PembelianReturForm::class);
});

/**
 * Stock Routing
 */
Route::middleware('auth')->group(function (){

    // daftar inventory
    Route::get('stock/inventory', \App\Http\Livewire\Stock\InventoryIndex::class)->name('inventory');
    Route::get('stock/inventory/{jenis}/{gudang}', \App\Http\Livewire\Stock\InventoryByJenisIndex::class);

    // stock transaksi
    Route::get('stock/transaksi/masuk', \App\Http\Livewire\Stock\StockMasukIndex::class)->name('stock.masuk');
    Route::get('stock/transaksi/masuk/{kondisi}', \App\Http\Livewire\Stock\StockMasukIndex::class);
    Route::get('stock/transaksi/masuk/{kondisi}/trans', \App\Http\Livewire\Stock\StockMasukForm::class);
    Route::get('stock/transaksi/masuk/{kondisi}/trans/{stockmasuk}', \App\Http\Livewire\Stock\StockMasukForm::class);

    Route::get('stock/transaksi/keluar', \App\Http\Livewire\Stock\StockKeluarIndex::class)->name('stock.keluar');
    Route::get('stock/transaksi/keluar/{kondisi}', \App\Http\Livewire\Stock\StockKeluarIndex::class);
    Route::get('stock/transaksi/keluar/{kondisi}/trans', \App\Http\Livewire\Stock\StockKeluarForm::class);
    Route::get('stock/transaksi/keluar/{kondisi}/trans/{stockkeluar}', \App\Http\Livewire\Stock\StockKeluarForm::class);
});

/**
 * Auth Routing
 */
Route::middleware('guest')->group(function (){
    Route::controller(\App\Http\Controllers\AuthController::class)->group(function (){
        Route::get('/login', 'index')->name('login');
        Route::post('/login', 'login');
        Route::get('/register', 'create')->name('register');
        Route::post('/register', 'store');
    });
});

Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'destroy'])->name('logout');

// require __DIR__.'/auth.php';
 require __DIR__.'/keuangan.php';
