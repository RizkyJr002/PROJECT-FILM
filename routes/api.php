<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HistoriController;
use App\Http\Controllers\Api\PembelianController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/reset-password/{token}', [ResetPasswordController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
});

Route::middleware(['verify.api.token'])->group(function () {
    Route::get('/tiket', [TicketController::class, 'index']);
    Route::get('/tiket/{id}', [TicketController::class, 'show']);
    Route::post('/tiket', [TicketController::class, 'store']);
    Route::put('/tiket/{id}', [TicketController::class, 'update']);
    Route::delete('/tiket/{id}', [TicketController::class, 'destroy']);

    Route::get('/histori', [HistoriController::class, 'index']);
    Route::get('/histori/{id}', [HistoriController::class, 'show']);
    Route::post('/histori', [HistoriController::class, 'store']);
    Route::delete('/histori/{id}', [HistoriController::class, 'destroy']);
    Route::get('/histori/search/{id_transaksi}', [HistoriController::class, 'search']);

    Route::get('/pembelian/{pengunjung}', [PembelianController::class, 'histori_pembelian']);
    Route::post('/pembelian', [PembelianController::class, 'store']);
});

Route::get('/users', [AuthController::class, 'index']);