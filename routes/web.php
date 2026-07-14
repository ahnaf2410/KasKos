<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DenahController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PersonalPaymentController;
use App\Http\Controllers\Admin\BillCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Tenant\DashboardController as TenantDashboardController;
use App\Http\Controllers\Tenant\RoomController as TenantRoomController;
use App\Http\Controllers\Tenant\PaymentController as TenantPaymentController;

// 1. Rute Publik (Splash Screen / Landing Page)
Route::get('/', function () {
    return view('welcome');
});

// 2. Rute Dashboard Utama (Membutuhkan Login)
Route::get('/dashboard', [DashboardController::class, 'admin'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 3. Kelompok Rute Auth Umum (Profile & Tenant)
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tenant
    Route::get('/tenant/dashboard', [TenantDashboardController::class, 'index'])->name('tenant.dashboard');
    Route::get('/tenant/kamar-saya', [TenantRoomController::class, 'index'])->name('tenant.rooms.index');


    // Pembayaran Patungan Tenant
    // Pembayaran Patungan Tenant
    Route::resource('/tenant/payments', TenantPaymentController::class)
        ->only([
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
            'show',
        ]);
});

// 4. Kelompok Rute Admin (Membutuhkan Login & Role Admin)
Route::middleware(['auth', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Resource CRUD
        Route::resource('rooms', RoomController::class);
        Route::resource('payments', PaymentController::class);
        Route::resource('personal-payments', PersonalPaymentController::class);

        // Kamar & Denah
        Route::get('/denah', [DenahController::class, 'index'])->name('denah.index');
        Route::patch('/rooms/{room}/clear', [RoomController::class, 'clear'])->name('rooms.clear');

        // Kategori Tagihan (Bill Categories)
        Route::get('/bill-categories', [BillCategoryController::class, 'index'])->name('bill-categories.index');
        Route::post('/bill-categories', [BillCategoryController::class, 'store'])->name('bill-categories.store');
        Route::post('/bill-categories/toggle/{id}', [BillCategoryController::class, 'toggleActive'])->name('bill-categories.toggle');
        Route::put('/bill-categories/{id}', [BillCategoryController::class, 'update'])->name('bill-categories.update');
        Route::delete('/bill-categories/{id}', [BillCategoryController::class, 'destroy'])->name('bill-categories.destroy');

        // Fitur Room History (Dinamis & AJAX)
        Route::get('/room-history', [RoomHistoryController::class, 'index'])->name('room-history.index');
        Route::get('/room-history/room/{roomId}/timeline', [RoomHistoryController::class, 'getRoomTimeline']);
    });

// 5. Rute Bawaan Laravel Breeze / Jetstream (Login, Register, Logout, dll)
require __DIR__.'/auth.php';
