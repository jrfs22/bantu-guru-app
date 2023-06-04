<?php

use App\Http\Controllers\api\AuthenticationController;
use App\Http\Controllers\api\DonasiController;
use App\Http\Controllers\api\DonaturController;
use App\Http\Controllers\api\KompetensiController;
use App\Http\Controllers\api\ListBimbelController;
use App\Http\Controllers\api\LowonganKerjaController;
use App\Http\Controllers\api\MateriBimbelController;
use App\Http\Controllers\api\MenuKaryaTulisController;
use App\Http\Controllers\api\PembimbingKaryaTulisController;
use App\Http\Controllers\api\PengajarBimbelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// Authentication routing
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'register']);

// Lowongan kerja routing
Route::get('/loker', [LowonganKerjaController::class, 'index']);
Route::get('/loker/{id}', [LowonganKerjaController::class, 'getById']);
Route::post('/loker', [LowonganKerjaController::class, 'store']);
Route::put('/loker/{id}', [LowonganKerjaController::class, 'update']);
Route::delete('/loker/{id}', [LowonganKerjaController::class, 'destroy']);

// Donasi routing
Route::get('/donasi', [DonasiController::class, 'index']);
Route::get('/donasi/{id}', [DonasiController::class, 'getById']);
Route::post('/donasi', [DonasiController::class, 'store']);
Route::put('/donasi/{id}', [DonasiController::class, 'update']);
Route::delete('/donasi/{id}', [DonasiController::class, 'destroy']);
// Route::apiResource('/donasi', DonasiController::class);

// Donatur routing
Route::post('/donatur/{donasi_id}', [DonaturController::class, 'store']);

// Routing kompetensi
Route::get('/kompetensi', [KompetensiController::class, 'index']);
Route::get('/kompetensi/{id}', [KompetensiController::class, 'getById']);
Route::post('/kompetensi', [KompetensiController::class, 'store']);
Route::put('/kompetensi/{id}', [KompetensiController::class, 'update']);
Route::delete('/kompetensi/{id}', [KompetensiController::class, 'destroy']);

// Routing Peserta kompetensi


// Routing list bimbel
Route::get('/list-bimbel', [ListBimbelController::class, 'index']);
Route::get('/list-bimbel/{id}', [ListBimbelController::class, 'getById']);
Route::post('/list-bimbel', [ListBimbelController::class, 'store']);
Route::put('/list-bimbel/{id}', [ListBimbelController::class, 'update']);
Route::delete('/list-bimbel/{id}', [ListBimbelController::class, 'destroy']);

// Routing Pengajar bimbel
Route::get('/pengajar-bimbel', [PengajarBimbelController::class, 'index']);
Route::post('/pengajar-bimbel', [PengajarBimbelController::class, 'store']);
Route::put('/pengajar-bimbel/{id}', [PengajarBimbelController::class, 'update']);

// Routing materi bimbel
Route::get('/materi-bimbel/{list_bimbel_id}/{user_id}', [MateriBimbelController::class, 'getById']);
Route::post('/materi-bimbel/{list_bimbel_id}/{user_id}', [MateriBimbelController::class, 'store']);
Route::put('/materi-bimbel/{id}', [MateriBimbelController::class, 'update']);
Route::delete('/materi-bimbel/{id}', [MateriBimbelController::class, 'destroy']);


// Routing Menu Karya Tulis
Route::get('/menu-karya-tulis', [MenuKaryaTulisController::class, 'index']);
Route::get('/menu-karya-tulis/{id}', [MenuKaryaTulisController::class, 'getById']);
Route::post('/menu-karya-tulis', [MenuKaryaTulisController::class, 'store']);
Route::put('/menu-karya-tulis/{id}', [MenuKaryaTulisController::class, 'update']);
Route::delete('/menu-karya-tulis/{id}', [MenuKaryaTulisController::class, 'destroy']);

// Routing Pembimbing Karya Tulis
Route::get('/pembimbing-karya-tulis', [PembimbingKaryaTulisController::class, 'index']);
// Route::get('/pembimbing-karya-tulis/{id}', [PembimbingKaryaTulisController::class, 'getById']);
Route::post('/pembimbing-karya-tulis', [PembimbingKaryaTulisController::class, 'store']);
// Route::put('/pembimbing-karya-tulis/{id}', [PembimbingKaryaTulisController::class, 'update']);
Route::delete('/pembimbing-karya-tulis/{id}', [PembimbingKaryaTulisController::class, 'destroy']);


Route::any('{url}', function(){
    return response()->json([
        'success' => false,
        'message' => 'Route not found'
    ], 500);
})->where('url', '.*');
// Route::fallback(function(){
//     return response()->json([
//         'success' => false,
//         'message' => 'Route not found'
//     ], 500);
// });