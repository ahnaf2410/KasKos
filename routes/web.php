<?php
use App\Http\Controllers\RoomHistoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DenahController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PersonalPaymentController;
use App\Http\Controllers\Admin\BillCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MoveRoomRequestController;
use App\Http\Controllers\Tenant\TagihanController;
use App\Http\Controllers\Tenant\DashboardController as TenantDashboardController;
use App\Http\Controllers\Tenant\RoomController as TenantRoomController;
use App\Http\Controllers\Tenant\PaymentController as TenantPaymentController;

use Illuminate\Support\Facades\Auth;

// 1. Rute Publik (Splash Screen / Landing Page)
Route::get('/', function () {
    return view('welcome');
});

// 2. Rute Dashboard Utama Admin (Membutuhkan Login)
Route::get('/dashboard', [DashboardController::class, 'admin'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 3. Kelompok Rute Auth Umum (Bisa diakses semua role yang login)
// Rute di sini akan menghasilkan nama 'profile.edit' sehingga COCOK dengan link di Blade Anda
Route::middleware(['auth', 'role:Tenant'])
    ->prefix('tenant')
    ->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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

        // Permintaan Pindah Kamar
        Route::get('/move-room-requests', [MoveRoomRequestController::class, 'index'])->name('move-room-requests.index');
        Route::post('/move-room-requests/{move_room_request}/approve', [MoveRoomRequestController::class, 'approve'])->name('move-room-requests.approve');
        Route::post('/move-room-requests/{move_room_request}/reject', [MoveRoomRequestController::class, 'reject'])->name('move-room-requests.reject');
    });

// 5. Kelompok Rute Tenant (Membutuhkan Login & Role Tenant)
Route::middleware(['auth', 'role:Tenant'])
    ->prefix('tenant')
    ->name('tenant.')
    ->group(function() {

        // Dashboard Tenant (URL: /tenant/dashboard)
        Route::get('/dashboard', [TenantDashboardController::class, 'index'])->name('dashboard');

        // Manajemen Kamar Tenant (URL: /tenant/kamar-saya)
        Route::get('/denah', [TenantRoomController::class, 'index'])->name('rooms.index');
        Route::get('/denah/{room}', [TenantRoomController::class, 'show'])->name('rooms.show');
        Route::post('/denah/{room}/select', [TenantRoomController::class, 'selectRoom'])->name('rooms.select');
        Route::post('/denah/{room}/request-move', [TenantRoomController::class, 'requestMove'])->name('rooms.request-move');

        // Route::get('/kamar-saya', [TenantRoomController::class, 'index'])->name('rooms.index');
        // Route::get('/kamar-saya/{room}', [TenantRoomController::class, 'show'])->name('rooms.show');
        // Route::post('/kamar-saya/{room}/select', [TenantRoomController::class, 'selectRoom'])->name('rooms.select');
        Route::get('/room-history', [TenantRoomController::class, 'history'])->name('rooms.history');

        // Pembayaran Patungan Tenant (URL: /tenant/payments)
        // Note: '/tenant' dihapus dari resource karena sudah otomatis ter-prefix dari group atas
        Route::resource('payments', TenantPaymentController::class)->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy', 'show'
        ]);

         Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');

        // 2. Menampilkan detail dari tagihan tertentu (Aksi tombol "Lihat Detail")
        Route::get('/tagihan/{id}', [TagihanController::class, 'show'])->name('tagihan.show');

        // 3. Memproses aksi pembayaran dari tagihan (Aksi tombol "Bayar Sekarang")
        Route::post('/tagihan/{id}/bayar', [TagihanController::class, 'bayar'])->name('tagihan.bayar');

    });

// 6. Rute Bawaan Laravel Breeze / Jetstream (Login, Register, Logout, dll)
require __DIR__.'/auth.php';
