<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\UserController;

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

Route::get('login', [LoginController::class, 'index'])->name('login.index');
Route::post('login', [LoginController::class, 'index'])->name('login');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/', function () {
        return redirect('dashboard');
    });
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::group(['prefix'=>'master'], function () {
        Route::middleware(['admin'])->group(function () {
            Route::get('mahasiswa', [MahasiswaController::class, 'index'])->name('master.mahasiswa');
            Route::post('mahasiswa/simpan', [MahasiswaController::class, 'simpan'])->name('master.mahasiswa.simpan');
            Route::post('mahasiswa/ubah', [MahasiswaController::class, 'ubah'])->name('master.mahasiswa.ubah');
            Route::get('mahasiswa/data/{id}', [MahasiswaController::class, 'data'])->name('master.mahasiswa.data');
            Route::delete('mahasiswa/hapus/{id}', [MahasiswaController::class, 'hapus'])->name('master.mahasiswa.hapus');
            
            Route::get('prodi', [ProdiController::class, 'index'])->name('master.prodi');
            Route::post('prodi/simpan', [ProdiController::class, 'simpan'])->name('master.prodi.simpan');
            Route::post('prodi/ubah', [ProdiController::class, 'ubah'])->name('master.prodi.ubah');
            Route::get('prodi/data/{id}', [ProdiController::class, 'data'])->name('master.prodi.data');
            Route::delete('prodi/hapus/{id}', [ProdiController::class, 'hapus'])->name('master.prodi.hapus');
    
            Route::get('pengguna', [PenggunaController::class, 'index'])->name('master.pengguna');
            Route::post('pengguna/simpan', [PenggunaController::class, 'simpan'])->name('master.pengguna.simpan');
            Route::post('pengguna/ubah', [PenggunaController::class, 'ubah'])->name('master.pengguna.ubah');
            Route::get('pengguna/data/{id}', [PenggunaController::class, 'data'])->name('master.pengguna.data');
            Route::delete('pengguna/hapus/{id}', [PenggunaController::class, 'hapus'])->name('master.pengguna.hapus');
        });
    });

    Route::group(['prefix'=>'transaction'], function () {
        Route::get('tenant', [TransactionController::class, 'index'])->name('transaction.tenant');
        Route::post('tenant/simpan', [TransactionController::class, 'simpan'])->name('transaction.tenant.simpan');
        Route::post('tenant/ubah', [TransactionController::class, 'ubah'])->name('transaction.tenant.ubah');
        Route::get('tenant/data/{id}', [TransactionController::class, 'data'])->name('transaction.tenant.data');
        Route::delete('tenant/hapus/{id}', [TransactionController::class, 'hapus'])->name('transaction.tenant.hapus');
    });

    Route::get('file-view/{dir}/{filename}', [DashboardController::class, 'fileView']);
});

Auth::routes([
    'register'  => false,
    'reset'     => false,
    'verify'    => false,
    'login'     => false
]);