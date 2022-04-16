<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\RekapanController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\PertanyaanController;


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

Route::get('survey', [SurveyController::class, 'index'])->name('survey.index');
Route::post('survey', [SurveyController::class, 'index'])->name('survey.simpan');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/', function () {
        return redirect('dashboard');
    });
    Route::middleware(['prodi'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        Route::get('rekapan', [RekapanController::class, 'index'])->name('laporan.rekapan');
        Route::post('rekapan/cetak', [RekapanController::class, 'cetak'])->name('laporan.rekapan.cetak');

        Route::get('penilaian', [RekapanController::class, 'penilaian'])->name('laporan.penilaian');
        Route::post('penilaian/cetak', [RekapanController::class, 'penilaian_cetak'])->name('laporan.penilaian.cetak');
    });

    Route::get('perkuliahan', [InputController::class, 'index'])->name('perkuliahan');
    Route::post('perkuliahan/simpan', [InputController::class, 'simpan'])->name('perkuliahan.simpan');
    Route::post('perkuliahan/ubah', [InputController::class, 'ubah'])->name('perkuliahan.ubah');
    Route::get('perkuliahan/data/{id}', [InputController::class, 'data'])->name('perkuliahan.data');
    Route::delete('perkuliahan/hapus/{id}', [InputController::class, 'hapus'])->name('perkuliahan.hapus');

    Route::group(['prefix'=>'master'], function () {
        Route::middleware(['admin'])->group(function () {

            Route::get('pengguna', [PenggunaController::class, 'index'])->name('master.pengguna');
            Route::post('pengguna/simpan', [PenggunaController::class, 'simpan'])->name('master.pengguna.simpan');
            Route::post('pengguna/ubah', [PenggunaController::class, 'ubah'])->name('master.pengguna.ubah');
            Route::get('pengguna/data/{id}', [PenggunaController::class, 'data'])->name('master.pengguna.data');
            Route::delete('pengguna/hapus/{id}', [PenggunaController::class, 'hapus'])->name('master.pengguna.hapus');

        });

        Route::middleware(['prodi'])->group(function () {
            Route::get('mahasiswa', [MahasiswaController::class, 'index'])->name('master.mahasiswa');
            Route::post('mahasiswa/simpan', [MahasiswaController::class, 'simpan'])->name('master.mahasiswa.simpan');
            Route::post('mahasiswa/ubah', [MahasiswaController::class, 'ubah'])->name('master.mahasiswa.ubah');
            Route::get('mahasiswa/data/{id}', [MahasiswaController::class, 'data'])->name('master.mahasiswa.data');
            Route::delete('mahasiswa/hapus/{id}', [MahasiswaController::class, 'hapus'])->name('master.mahasiswa.hapus');
            Route::post('mahasiswa/upload', [MahasiswaController::class, 'upload'])->name('master.mahasiswa.upload');
            
            Route::get('prodi', [ProdiController::class, 'index'])->name('master.prodi');
            Route::post('prodi/simpan', [ProdiController::class, 'simpan'])->name('master.prodi.simpan');
            Route::post('prodi/ubah', [ProdiController::class, 'ubah'])->name('master.prodi.ubah');
            Route::get('prodi/data/{id}', [ProdiController::class, 'data'])->name('master.prodi.data');
            Route::delete('prodi/hapus/{id}', [ProdiController::class, 'hapus'])->name('master.prodi.hapus');
            Route::post('prodi/upload', [ProdiController::class, 'upload'])->name('master.prodi.upload');

            Route::get('dosen', [DosenController::class, 'index'])->name('master.dosen');
            Route::post('dosen/simpan', [DosenController::class, 'simpan'])->name('master.dosen.simpan');
            Route::post('dosen/ubah', [DosenController::class, 'ubah'])->name('master.dosen.ubah');
            Route::get('dosen/data/{id}', [DosenController::class, 'data'])->name('master.dosen.data');
            Route::delete('dosen/hapus/{id}', [DosenController::class, 'hapus'])->name('master.dosen.hapus');
            Route::post('dosen/upload', [DosenController::class, 'upload'])->name('master.dosen.upload');

            Route::get('ruang', [RuangController::class, 'index'])->name('master.ruang');
            Route::post('ruang/simpan', [RuangController::class, 'simpan'])->name('master.ruang.simpan');
            Route::post('ruang/ubah', [RuangController::class, 'ubah'])->name('master.ruang.ubah');
            Route::get('ruang/data/{id}', [RuangController::class, 'data'])->name('master.ruang.data');
            Route::delete('ruang/hapus/{id}', [RuangController::class, 'hapus'])->name('master.ruang.hapus');
            Route::post('ruang/upload', [RuangController::class, 'upload'])->name('master.ruang.upload');

            Route::get('mata-kuliah', [MataKuliahController::class, 'index'])->name('master.mata-kuliah');
            Route::post('mata-kuliah/simpan', [MataKuliahController::class, 'simpan'])->name('master.mata-kuliah.simpan');
            Route::post('mata-kuliah/ubah', [MataKuliahController::class, 'ubah'])->name('master.mata-kuliah.ubah');
            Route::get('mata-kuliah/data/{id}', [MataKuliahController::class, 'data'])->name('master.mata-kuliah.data');
            Route::delete('mata-kuliah/hapus/{id}', [MataKuliahController::class, 'hapus'])->name('master.mata-kuliah.hapus');
            Route::post('mata-kuliah/upload', [MataKuliahController::class, 'upload'])->name('master.mata-kuliah.upload');

            Route::get('semester', [SemesterController::class, 'index'])->name('master.semester');
            Route::post('semester/simpan', [SemesterController::class, 'simpan'])->name('master.semester.simpan');
            Route::post('semester/ubah', [SemesterController::class, 'ubah'])->name('master.semester.ubah');
            Route::get('semester/data/{id}', [SemesterController::class, 'data'])->name('master.semester.data');
            Route::delete('semester/hapus/{id}', [SemesterController::class, 'hapus'])->name('master.semester.hapus');

            Route::get('pertanyaan-survey', [PertanyaanController::class, 'index'])->name('master.pertanyaan-survey');
            Route::post('pertanyaan-survey/simpan', [PertanyaanController::class, 'simpan'])->name('master.pertanyaan-survey.simpan');
            Route::post('pertanyaan-survey/ubah', [PertanyaanController::class, 'ubah'])->name('master.pertanyaan-survey.ubah');
            Route::get('pertanyaan-survey/data/{id}', [PertanyaanController::class, 'data'])->name('master.pertanyaan-survey.data');
            Route::delete('pertanyaan-survey/hapus/{id}', [PertanyaanController::class, 'hapus'])->name('master.pertanyaan-survey.hapus');
        });
    });

    Route::group(['prefix'=>'transaction'], function () {
       
    });

    Route::get('file-view/{dir}/{filename}', [DashboardController::class, 'fileView']);
});

Auth::routes([
    'register'  => false,
    'reset'     => false,
    'verify'    => false,
    'login'     => false
]);