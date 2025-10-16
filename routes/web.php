<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Rute yang dapat diakses tanpa login)
|--------------------------------------------------------------------------
| Halaman utama ('/') diarahkan ke Login.
*/

// 1. Login (Halaman Index)
Route::get('/', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit')->middleware('guest');

// 2. Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit')->middleware('guest');

// 3. Logout (Diproses di dalam group 'auth' menggunakan POST)


/*
|--------------------------------------------------------------------------
| Protected Routes (Rute yang memerlukan autentikasi)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Pemasukan (Menggunakan Resource Controller)
    // Mencakup: index, create, store, show, edit, update, destroy
    Route::resource('pemasukan', PemasukanController::class);

    // CRUD Pengeluaran (Menggunakan Resource Controller)
    // Mencakup: index, create, store, show, edit, update, destroy
    Route::resource('pengeluaran', PengeluaranController::class);
    
    // Laporan (Hanya memerlukan satu route untuk menampilkan dan memfilter)
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    // routes/web.php (Di dalam group middleware('auth'))

// Laporan Export (Harus berada di atas index jika menggunakan GET)
Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');

// Laporan Index
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    
    /* * Catatan: Jika Anda ingin menambahkan CRUD untuk manajemen User (Admin), 
     * Anda perlu membuat UserController dan menambahkan Middleware kustom 'role:admin'.
     * Contoh:
     * Route::resource('users', UserController::class)->middleware('role:admin');
     */
Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');

// Route Index Laporan tetap sama
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});