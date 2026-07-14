<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\PaymentController; //payment-melani-coba
use App\Http\Controllers\DenahController;
use App\Http\Controllers\Admin\BillCategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::middleware(['auth', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('rooms', RoomController::class);
        Route::resource('payments', PaymentController::class); //payment-melani-coba
        Route::get('/denah', [DenahController::class, 'index'])
        ->name('denah.index');
























































































































































































































    Route::get('/bill-categories', [BillCategoryController::class, 'index'])->name('bill-categories.index');
    Route::post('/bill-categories', [BillCategoryController::class, 'store'])->name('bill-categories.store');
    Route::post('/bill-categories/toggle/{id}', [BillCategoryController::class, 'toggleActive'])->name('bill-categories.toggle');
    Route::put('/bill-categories/{id}', [BillCategoryController::class, 'update'])->name('bill-categories.update');
    Route::delete('/bill-categories/{id}', [BillCategoryController::class, 'destroy'])->name('bill-categories.destroy');

    });

require __DIR__.'/auth.php';
