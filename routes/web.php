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
    Route::get('/master/produk', \App\Http\Livewire\Master\ProdukIndex::class);
    Route::get('/master/produk/kategori', \App\Http\Livewire\Master\ProdukKategoriIndex::class);
    Route::get('/master/produk/kategoriharga', \App\Http\Livewire\Master\ProdukKategoriHargaIndex::class);
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

// require __DIR__.'/auth.php';
