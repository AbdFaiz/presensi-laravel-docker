<?php

use App\Http\Controllers\Admin\KelasKuliahController;
use App\Http\Controllers\Admin\KrsDetailController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\Admin\ProgramStudiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Dosen\JadwalKuliahController as DosenJadwalController;
use App\Http\Controllers\Dosen\PresensiController as DosenPresensiController;
use App\Http\Controllers\Mahasiswa\KrsController;
use App\Http\Controllers\Mahasiswa\PresensiController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('dashboard', function () {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => view('dashboards.admin'),
            'dosen' => view('dashboards.dosen'),
            'mahasiswa' => view('dashboards.mahasiswa'),
            default => view('dashboard'),
        };
    })->name('dashboard');

    Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('program-studi', [ProgramStudiController::class, 'index'])->name('prodi.index');
        Route::get('program-studi/create', [ProgramStudiController::class, 'create'])->name('prodi.create');
        Route::post('program-studi', [ProgramStudiController::class, 'store'])->name('prodi.store');
        Route::get('program-studi/{programStudi}/edit', [ProgramStudiController::class, 'edit'])->name('prodi.edit');
        Route::put('program-studi/{programStudi}', [ProgramStudiController::class, 'update'])->name('prodi.update');
        Route::delete('program-studi/{programStudi}', [ProgramStudiController::class, 'destroy'])->name('prodi.destroy');

        Route::get('mata-kuliah', [MataKuliahController::class, 'index'])->name('mk.index');
        Route::get('mata-kuliah/create', [MataKuliahController::class, 'create'])->name('mk.create');
        Route::post('mata-kuliah', [MataKuliahController::class, 'store'])->name('mk.store');
        Route::get('mata-kuliah/{mataKuliah}/edit', [MataKuliahController::class, 'edit'])->name('mk.edit');
        Route::put('mata-kuliah/{mataKuliah}', [MataKuliahController::class, 'update'])->name('mk.update');
        Route::delete('mata-kuliah/{mataKuliah}', [MataKuliahController::class, 'destroy'])->name('mk.destroy');

        Route::get('kelas', [KelasKuliahController::class, 'index'])->name('kelas.index');
        Route::get('kelas/create', [KelasKuliahController::class, 'create'])->name('kelas.create');
        Route::post('kelas', [KelasKuliahController::class, 'store'])->name('kelas.store');
        Route::get('kelas/{kelasKuliah}/edit', [KelasKuliahController::class, 'edit'])->name('kelas.edit');
        Route::put('kelas/{kelasKuliah}', [KelasKuliahController::class, 'update'])->name('kelas.update');
        Route::delete('kelas/{kelasKuliah}', [KelasKuliahController::class, 'destroy'])->name('kelas.destroy');

        Route::get('krs', [KrsDetailController::class, 'index'])->name('krs.index');
        Route::post('krs/{krsDetail}/approve', [KrsDetailController::class, 'approve'])->name('krs.approve');
        Route::post('krs/{krsDetail}/reject', [KrsDetailController::class, 'reject'])->name('krs.reject');
    });

    Route::prefix('dosen')->middleware('dosen')->name('dosen.')->group(function () {
        Route::get('jadwal', [DosenJadwalController::class, 'index'])->name('jadwal.index');
        Route::get('jadwal/create', [DosenJadwalController::class, 'create'])->name('jadwal.create');
        Route::post('jadwal', [DosenJadwalController::class, 'store'])->name('jadwal.store');
        Route::put('jadwal/{jadwalKuliah}/toggle', [DosenJadwalController::class, 'toggle'])->name('jadwal.toggle');

        Route::get('presensi/{jadwalKuliah}', [DosenPresensiController::class, 'show'])->name('presensi.show');
        Route::get('presensi/{jadwalKuliah}/export', [DosenPresensiController::class, 'export'])->name('presensi.export');
    });

    Route::prefix('mahasiswa')->middleware('mahasiswa')->name('mhs.')->group(function () {
        Route::get('krs', [KrsController::class, 'index'])->name('krs.index');
        Route::get('krs/daftar', [KrsController::class, 'daftar'])->name('krs.daftar');
        Route::post('krs/{kelasKuliah}/ambil', [KrsController::class, 'ambil'])->name('krs.ambil');
        Route::post('krs/{krsDetail}/batal', [KrsController::class, 'batal'])->name('krs.batal');

        Route::get('presensi', [PresensiController::class, 'index'])->name('presensi.index');
        Route::post('presensi/{jadwalKuliah}/submit', [PresensiController::class, 'submit'])->name('presensi.submit');
    });
});

require __DIR__.'/settings.php';
