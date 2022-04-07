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

Route::middleware('auth')->group(function (){

    // closed cash
    Route::get('closedcash', \App\Http\Livewire\CloseCashIndex::class)->name('closedcash');

    // config hpp
    Route::get('config/hpp', \App\Http\Livewire\Config\ConfigHpp::class)->name('config.hpp');

    // config jurnal
    Route::get('config/jurnal', \App\Http\Livewire\Config\ConfigJurnalForm::class)->name('config.jurnal');

});

/**
 * Penjualan Routing
 */
Route::middleware('auth')->group(function (){

    // penjualan
    Route::get('penjualan', \App\Http\Livewire\Penjualan\PenjualanIndex::class)->name('penjualan');
    Route::get('penjualan/trans', \App\Http\Livewire\Penjualan\PenjualanForm::class)->name('penjualan.trans');
    Route::get('penjualan/trans/{penjualan}', \App\Http\Livewire\Penjualan\PenjualanForm::class);

    Route::get('penjualan/print/{penjualan}', [\App\Http\Controllers\Sales\ReceiptController::class, 'penjualanDotMatrix']);

    Route::get('penjualan/retur/{kondisi}', \App\Http\Livewire\Penjualan\PenjualanReturIndex::class);
    Route::get('penjualan/retur/{kondisi}/trans', \App\Http\Livewire\Penjualan\PenjualanReturForm::class);
    Route::get('penjualan/retur/{kondisi}/trans/{retur}', \App\Http\Livewire\Penjualan\PenjualanReturForm::class);

    Route::get('penjualan/retur/print/{penjualanRetur}', [\App\Http\Controllers\Sales\ReceiptController::class, 'print']);
});

Route::middleware('auth')->group(function(){

    // pembelian
    Route::get('pembelian', \App\Http\Livewire\Purchase\PembelianIndex::class)->name('pembelian');
    Route::get('pembelian/trans', \App\Http\Livewire\Purchase\PembelianForm::class)->name('pembelian.trans');
    Route::get('pembelian/trans/{pembelian}', \App\Http\Livewire\Purchase\PembelianForm::class);

    Route::get('pembelian/retur/{kondisi}', \App\Http\Livewire\Purchase\PembelianReturIndex::class)->name('pembelian.retur');
    Route::get('pembelian/retur/{kondisi}/trans/', \App\Http\Livewire\Purchase\PembelianReturForm::class);
    Route::get('pembelian/retur/trans/{retur}', \App\Http\Livewire\Purchase\PembelianReturForm::class);

    // pembelian (dari buku internal)
    Route::get('pembelian/internal', \App\Http\Livewire\Purchase\PembelianInternalIndex::class)->name('pembelian.internal');
    Route::get('pembelian/internal/trans', \App\Http\Livewire\Purchase\PembelianInternalForm::class);
    Route::get('pembelian/internal/trans/{pembelian}', \App\Http\Livewire\Purchase\PembelianInternalForm::class);
});

/**
 * Stock Routing
 */
Route::middleware('auth')->group(function (){

    // daftar inventory
    Route::get('stock/inventory', \App\Http\Livewire\Stock\InventoryIndex::class)->name('inventory');
    Route::get('stock/inventory/{jenis}/{gudang}', \App\Http\Livewire\Stock\InventoryByJenisIndex::class);

    Route::get('stock/print/stockopname', [\App\Http\Controllers\Stock\StockOpnameController::class, 'reportStockByProduk'])->name('stock.print.stockopname');

    // stock transaksi
    Route::get('stock/transaksi/masuk', \App\Http\Livewire\Stock\StockMasukIndex::class)->name('stock.masuk');
    Route::get('stock/transaksi/masuk/{kondisi}', \App\Http\Livewire\Stock\StockMasukIndex::class);
    Route::get('stock/transaksi/masuk/trans/{kondisi}', \App\Http\Livewire\Stock\StockMasukForm::class);
    Route::get('stock/transaksi/masuk/trans/{kondisi}/{stockmasuk}', \App\Http\Livewire\Stock\StockMasukForm::class);

    Route::get('stock/transaksi/keluar', \App\Http\Livewire\Stock\StockKeluarIndex::class)->name('stock.keluar');
    Route::get('stock/transaksi/keluar/{kondisi}', \App\Http\Livewire\Stock\StockKeluarIndex::class);
    Route::get('stock/transaksi/keluar/trans/{kondisi}', \App\Http\Livewire\Stock\StockKeluarForm::class);
    Route::get('stock/transaksi/keluar/trans/{kondisi}/{stockkeluar}', \App\Http\Livewire\Stock\StockKeluarForm::class);


    Route::get('stock/transaksi/opname', \App\Http\Livewire\Stock\StockOpnameIndex::class)->name('stock.opname');
    Route::get('stock/transaksi/opname/{jenis}', \App\Http\Livewire\Stock\StockOpnameIndex::class);
    Route::get('stock/transaksi/opname/trans/{jenis}', \App\Http\Livewire\Stock\StockOpnameForm::class);
    Route::get('stock/transaksi/opname/trans/{jenis}/{stockOpname_id}', \App\Http\Livewire\Stock\StockOpnameForm::class);

    Route::get('stock/transaksi/mutasi/baik/baik',  \App\Http\Livewire\Stock\StockMutasiBaikBaikIndex::class)->name('stock.mutasi.baik.baik');
    Route::get('stock/transaksi/mutasi/baik/baik/trans',  \App\Http\Livewire\Stock\StockMutasiBaikBaikForm::class)->name('stock.mutasi.baik.baik.trans');
    Route::get('stock/transaksi/mutasi/baik/rusak',  \App\Http\Livewire\Stock\StockMutasiBaikRusakIndex::class)->name('stock.mutasi.baik.rusak');
    Route::get('stock/transaksi/mutasi/baik/rusak/trans',  \App\Http\Livewire\Stock\StockMutasiBaikRusakForm::class)->name('stock.mutasi.baik.rusak.trans');
    Route::get('stock/transaksi/mutasi/rusak/rusak',  \App\Http\Livewire\Stock\StockMutasiRusakRusakIndex::class)->name('stock.mutasi.rusak.rusak');
    Route::get('stock/transaksi/mutasi/rusak/rusak/trans',  \App\Http\Livewire\Stock\StockMutasiRusakRusakForm::class)->name('stock.mutasi.rusak.rusak.trans');

    // numpang stock
    Route::get('stock/stockakhir', \App\Http\Livewire\Stock\StockAkhirIndex::class)->name('stock.stockakhir');
    Route::get('stock/stockakhir/transaksi', \App\Http\Livewire\Stock\StockAkhirForm::class)->name('stock.stockakhir.transaksi');
    Route::get('stock/stockakhir/transaksi/{id}', \App\Http\Livewire\Stock\StockAkhirForm::class);

    Route::get('stock/transaksi/internal', \App\Http\Livewire\Stock\StockMasukInternalIndex::class)->name('stock.masuk.internal.index');
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
