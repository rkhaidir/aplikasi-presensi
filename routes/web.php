<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\Admin\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/presensi', function () {
    return view('presence');
})->name('presensi');

Route::get('/sukses', function () {
    return view('success');
})->name('sukses');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('admin.dashboard');
    Route::get('/jurusan', [MajorController::class, 'index'])->name('admin.jurusan');
    Route::get('/kelas', [GradeController::class, 'index'])->name('admin.kelas');
    Route::get('/siswa', [StudentController::class, 'index'])->name('admin.siswa');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
