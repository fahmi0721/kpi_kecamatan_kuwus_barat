<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


/**
  * Route DASHBOARD
*/
use App\Http\Controllers\DashboardController;
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/task-summary', [DashboardController::class, 'get_count'])->name('dashboard.task-summary');
    Route::get('/chart-task-posted', [DashboardController::class, 'get_barchar'])->name('dashboard.chart-task-posted');
});


/**
  * Route Jabatn
*/
use App\Http\Controllers\JabatanController;
Route::group(['middleware' => ['auth']], function () {
    Route::get('/m-jabatan', [JabatanController::class, 'index'])->name('jabatan');
    Route::get('/m-jabatan/create', [JabatanController::class, 'create'])->name('jabatan.create');
    Route::get('/m-jabatan/list', [JabatanController::class, 'list'])->name('jabatan.list');
    Route::get('/m-jabatan/edit', [JabatanController::class, 'edit'])->name('jabatan.edit');
    Route::post('/m-jabatan/save', [JabatanController::class, 'store'])->name('jabatan.save');
    Route::put('/m-jabatan/update/{id}', [JabatanController::class, 'update'])->name('jabatan.update');
    Route::delete('/m-jabatan/delete/{id}', [JabatanController::class, 'destroy'])->name('jabatan.delete');
});

/**
  * Route Pegawai
*/
use App\Http\Controllers\PegawaiController;
Route::group(['middleware' => ['auth']], function () {
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai');
    Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
    Route::get('/pegawai/list', [PegawaiController::class, 'list'])->name('pegawai.list');
    Route::get('/pegawai/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::post('/pegawai/save', [PegawaiController::class, 'store'])->name('pegawai.save');
    Route::put('/pegawai/update/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/delete/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.delete');
});

/**
  * Route User Login
*/

use App\Http\Controllers\UserController;
Route::group(['middleware' => ['auth']], function () {
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::get('/user/data', [UserController::class, 'list_data'])->name('user.data');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/save', [UserController::class, 'store'])->name('user.save');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
});


use App\Http\Controllers\TaskController;
Route::group(['middleware' => ['auth']], function () {
    Route::get('/task', [TaskController::class, 'index'])->name('task');
    Route::get('/task/data', [TaskController::class, 'list_data'])->name('task.data');
    Route::get('/task-create', [TaskController::class, 'create'])->name('task.create');
    Route::get('/task/edit', [TaskController::class, 'edit'])->name('task.edit');
    Route::get('/task/view', [TaskController::class, 'view'])->name('task.view');
    Route::get('/task/approve', [TaskController::class, 'approve'])->name('task.approve');
    Route::post('/task/approve', [TaskController::class, 'update_approve'])->name('task.update_approve');
    Route::post('/task/save', [TaskController::class, 'store'])->name('task.save');
    Route::put('/task/update/{id}', [TaskController::class, 'update'])->name('task.update');
    Route::delete('/task/delete/{id}', [TaskController::class, 'destroy'])->name('task.delete');
    Route::get('/task/cetak-pdf/{id}', [TaskController::class, 'cetakPdf'])
    ->name('task.cetak-pdf');
});
Route::get('/task/verifikasi/{id}', [TaskController::class, 'verifikasi'])
    ->name('task.verifikasi');
