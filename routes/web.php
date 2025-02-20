<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\barangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\pegawaiController;
use App\Http\Controllers\pelangganController;
use App\Http\Controllers\stokController;
use App\Http\Controllers\suplierController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get( '/', [AuthController::class, 'index']);
Route::post( '/', [AuthController::class, 'login'])->name('login');

route::middleware(['auth', 'cekLevel:superadmin,admin'])->group( function(){

        Route::get( '/dashboard', [dashboardController::class, 'index']);

        Route::get('/logout', [AuthController::class, 'Logout']);


    route::controller(pegawaiController::class)->group(function(){

        route::get('/pegawai','index');

        route::post('/pegawai/add', 'store')->name('addPegawai');

        route::get('pegawai/edit/{id}', 'edit');
        route::post('pegawai/edit/{id}', 'update'); //->disini

        route::get('/pegawai/delete/{id}','destroy');
    });
/**
 *  ini routing stok
 */
route::controller(stokController::class)->group(function(){

    route::get('/stok', 'index');

    route::get('/stok/add', 'create');
    route::post('/stok/add', 'store');

    route::get('/stok/edit/{id}', 'edit');
    route::post('/stok/edit/{id}', 'update');


});




/**
 * ini routing barang masuk
 */
Route::controller(BarangMasukController::class)->group(function(){
 Route::get('/Barang-Masuk', 'index');

    Route::get('Barang-Masuk/add', 'create');
    Route::post('/Barang-Masuk/add', 'store');


});





 /**
  * ini routing barang keluar
  */
    Route::controller(barangKeluarController::class)->group(function(){
        Route::get('/barang-keluar', 'index');

        Route::get('/barang-keluar/add', 'create');
        Route::post('/barang-keluar/add', 'store');

        Route::post('/barang-keluar/save', 'savebarangKeluar')->name('add-barang-Keluar');

    });



  /**
   * ini routing pelanggan
   */

   route::controller(pelangganController::class)->group(function(){
    route::get('/pelanggan','index');

    route::get('/pelanggan/add', 'create');
    route::post('/pelanggan/add', 'store');

    route::get('/pelanggan/edit/{id}', 'edit');
    route::post('/pelanggan/edit/{id}', 'update');

    route::get('/pelanggan/{id}', 'destroy');
});





   /**
    * ini routing suplier
    */

    route::controller(suplierController::class)->group(function(){
        route::get('/suplier','index');

        route::get('/suplier/add', 'create');
        route::post('/suplier/add', 'store');

        route::get('/suplier/edit/{id}', 'edit');
        route::post('/suplier/edit/{id}', 'update');

        route::get('/suplier/{id}', 'destroy');
    });


});



