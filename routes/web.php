<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\PaymentController; //payment-melani-coba
use App\Http\Controllers\DenahController;
use App\Http\Controllers\Admin\DashboardController;

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

});

Route::middleware(['auth', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

       Route::resource('rooms', RoomController::class);
        Route::resource('payments', PaymentController::class); //payment-melani-coba
        Route::get('/denah', [DenahController::class, 'index'])
        ->name('denah.index');
        Route::patch(
    'rooms/{room}/clear',
    [RoomController::class,'clear']
)->name('rooms.clear');


    });

require __DIR__.'/auth.php';
