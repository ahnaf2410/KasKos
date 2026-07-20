<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomApiController;
use App\Http\Controllers\Api\BillCategoryApiController;

// 1. Route CRUD Room (Menggunakan bahasa Inggris 'room')
Route::apiResource('room', RoomApiController::class);

// 2. Route untuk mengambil riwayat room tertentu
Route::get('room/{id}/history', [RoomApiController::class, 'history']);


// 3. Route Kategori Tagihan (read-only: index + show)
Route::get('bill-categories', [BillCategoryApiController::class, 'index']);
Route::get('bill-categories/{billCategory}', [BillCategoryApiController::class, 'show']);
