<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoomController;

use App\Http\Controllers\DenahController;
use App\Http\Controllers\Admin\BillCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Tenant\DashboardController as TenantDashboardController;
use App\Http\Controllers\Admin\PaymentController; //payment-melani
use App\Http\Controllers\Admin\PersonalPaymentController;//personal-payment-melani
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Tenant\RoomController as TenantRoomController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'admin'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tenant/dashboard', [TenantDashboardController::class, 'index'])->name('tenant.dashboard');
});

Route::middleware(['auth', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

       Route::resource('rooms', RoomController::class);
        Route::resource('payments', PaymentController::class); //payment-melani-coba
        Route::resource('personal-payments', PersonalPaymentController::class); //personal payment
        Route::get('/denah', [DenahController::class, 'index'])
        ->name('denah.index');
        Route::patch(
    'rooms/{room}/clear',
    [RoomController::class,'clear']
)->name('rooms.clear');


        //pembayaran patungan-melani
        // Route::put('payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
        // Route::put('payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');























































































































































































































    Route::get('/bill-categories', [BillCategoryController::class, 'index'])->name('bill-categories.index');
    Route::post('/bill-categories', [BillCategoryController::class, 'store'])->name('bill-categories.store');
    Route::post('/bill-categories/toggle/{id}', [BillCategoryController::class, 'toggleActive'])->name('bill-categories.toggle');
    Route::put('/bill-categories/{id}', [BillCategoryController::class, 'update'])->name('bill-categories.update');
    Route::delete('/bill-categories/{id}', [BillCategoryController::class, 'destroy'])->name('bill-categories.destroy');

    });

Route::middleware(['auth'])->group(function(){


    Route::get(
        '/tenant/kamar-saya',
        [TenantRoomController::class,'index']
    )
    ->name('tenant.rooms.index');


});




require __DIR__.'/auth.php';

