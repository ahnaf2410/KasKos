<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoomApiController;
use App\Http\Controllers\Api\BillCategoryApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// ==================== Public API Routes ====================

// Auth (tanpa token)
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// ==================== Protected API Routes (Sanctum) ====================
Route::middleware('auth:sanctum')->group(function () {

    // Auth (memerlukan token)
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Room CRUD
    Route::apiResource('room', RoomApiController::class);

    // Room History
    Route::get('room/{id}/history', [RoomApiController::class, 'history']);

    // Bill Categories (read-only)
    Route::get('bill-categories', [BillCategoryApiController::class, 'index']);
    Route::get('bill-categories/{billCategory}', [BillCategoryApiController::class, 'show']);
});

