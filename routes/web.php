<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. Dashboard Utama
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 2. Profile User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 3. Fitur Laporan (User/Mahasiswa)
    Route::get('/lapor', [ReportController::class, 'create'])->name('report.create');
    Route::post('/lapor', [ReportController::class, 'store'])->name('report.store');
    Route::get('/lapor/riwayat', [ReportController::class, 'history'])->name('report.history');
    Route::get('/lapor/{id}', [ReportController::class, 'show'])->name('report.show');

    // 4. Fitur Admin & Kasubag Sarpras (Grup Prefix Admin)
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Kelola Laporan
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
        Route::patch('/reports/{id}', [ReportController::class, 'update'])->name('reports.update');
        Route::patch('/reports/{id}/status', [ReportController::class, 'updateStatus'])->name('reports.updateStatus');
        Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');
       
        // CRUD Pengguna / Manajemen Akun
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create'); 
        Route::post('/users', [UserController::class, 'store'])->name('users.store');        
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::patch('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // 🟢 PERBAIKAN RUTAS EXPORT: Sekarang namanya pas murni menjadi admin.reports.export.excel
        Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
        Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');

        // Kontrol Manajemen Panduan (Khusus Admin)
        Route::get('/panduan/create', [ReportController::class, 'createPanduan'])->name('guides.create');
        Route::post('/panduan/store', [ReportController::class, 'storePanduan'])->name('guides.store');
        Route::get('/panduan/{id}/edit', [ReportController::class, 'editPanduan'])->name('guides.edit');
        Route::put('/panduan/{id}', [ReportController::class, 'updatePanduan'])->name('guides.update');
        Route::delete('/panduan/{id}', [ReportController::class, 'destroyPanduan'])->name('guides.destroy');

        // Rekap Review Mahasiswa
        Route::get('/reviews', [ReportController::class, 'viewReviews'])->name('reviews.index');
    });

    // 5. Fitur Panduan Umum (Semua User yang Login Bisa Lihat)
    Route::get('/panduan', [ReportController::class, 'viewPanduan'])->name('panduan');

    // 6. Fitur Timbal Balik Review & Kepuasan (Mahasiswa)
    Route::post('/review/store', [ReportController::class, 'storeReview'])->name('review.store');
    Route::get('/user/reviews', [ReportController::class, 'userReviews'])->name('user.reviews.index');
    Route::delete('/review/delete/{id}', [ReportController::class, 'destroyReview'])->name('review.destroy');
});

require __DIR__.'/auth.php';