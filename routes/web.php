<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\MutasiBarangController;
use App\Http\Controllers\DetailMutasiBarangController;

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

Route::get('/', [MutasiBarangController::class, 'index'])->name("mutasibarang.index");

Route::get('/barang/searchQuery/', [BarangController::class, 'searchQuery']);
Route::get('/mutasibarang/laporan', [MutasiBarangController::class, 'laporan']);
Route::post('/mutasibarang/laporan', [MutasiBarangController::class, 'laporan'])->name("mutasibarang.laporan");

Route::resource('barang', BarangController::class);
Route::resource('mutasibarang', MutasiBarangController::class);