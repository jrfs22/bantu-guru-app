<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\LowonganKerjaController;
use App\Http\Controllers\api\DonasiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::apiResource('/loker', [LowonganKerjaController::class, 'index']);
// Route::post('/loker', [LowonganKerjaController::class, 'store']);
// Route::put('/loker/{id}', [LowonganKerjaController::class, 'update']);
// Route::delete('/loker/{id}', [LowonganKerjaController::class, 'destroy']);
Route::apiResource('/loker', LowonganKerjaController::class);

Route::get('/donasi', [DonasiController::class, 'index']);
Route::get('/donasi/{id}', [DonasiController::class, 'getById']);
Route::post('/donasi', [DonasiController::class, 'store']);