<?php

use App\Http\Controllers\GolonganController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\JenisKegiatanController;
use App\Http\Controllers\KompetensiKhususController;
use App\Http\Controllers\PenugasanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnggotaController;
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
        $param['pageIcon'] = 'fa fa-home';
        $param['pageTitle'] = 'Aplikasi PUSKOGAP';
        return view('dashboard',$param);
    })->middleware(['auth'])->name('dashboard');

    Route::resource('data-master/golongan', GolonganController::class);
    Route::resource('data-master/jabatan', JabatanController::class);
    Route::resource('data-master/unit-kerja', UnitKerjaController::class);
    Route::resource('data-master/kompetensi-khusus', KompetensiKhususController::class);
    Route::resource('data-master/jenis-kegiatan', JenisKegiatanController::class);
    Route::prefix('penugasan')->group(function () {
        Route::resource('master-penugasan', PenugasanController::class);
        Route::get('jadwal', [PenugasanController::class, 'jadwal']);
        Route::get('get-anggota', [PenugasanController::class, 'getAnggota']);
        Route::get('cek-anggota', [PenugasanController::class, 'CekAnggota']);
        Route::get('filter-anggota-free', [PenugasanController::class, 'filterAnggotaFree']);
        Route::post('send-whatsapp', [PenugasanController::class, 'sendWhatsapp'])->name('penugasan.send-wa');
    });
    Route::resource('penugasan', PenugasanController::class);
    Route::prefix('data-master/user')->group(function(){
        Route::resource('user', UserController::class);
        Route::get('change-password', [UserController::class, 'changePassword'])->name('change_password');
        Route::put('change-password/{id}', [UserController::class, 'updatePassword'])->name('update_password');
    });
    Route::resource('data-master/user', UserController::class);
    Route::resource('data-master/anggota', AnggotaController::class);
});

require __DIR__.'/auth.php';
