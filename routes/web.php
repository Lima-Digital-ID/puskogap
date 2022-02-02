<?php

use App\Http\Controllers\GolonganController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\JenisKegiatanController;
use App\Http\Controllers\KompetensiKhususController;
use App\Http\Controllers\PenugasanController;
use App\Http\Controllers\UserController;
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
    return view('auth.login');
});
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');

    Route::resource('golongan', GolonganController::class);
    Route::resource('jabatan', JabatanController::class);
    Route::resource('unit-kerja', UnitKerjaController::class);
    Route::resource('kompetensi-khusus', KompetensiKhususController::class);
    Route::resource('jenis-kegiatan', JenisKegiatanController::class);
    Route::prefix('penugasan')->group(function () {
        Route::resource('master-penugasan', PenugasanController::class);
        Route::get('cek-anggota', 'PenugasanController@getAnggota');
    });
    Route::resource('penugasan', PenugasanController::class);
    Route::resource('user', UserController::class);
});

require __DIR__.'/auth.php';
