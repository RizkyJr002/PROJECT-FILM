<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\HistoriController;
use App\Http\Controllers\Api\PembayaranController;
use App\Http\Controllers\Api\PembelianController;
use App\Http\Controllers\Api\QrCodeController;
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
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
});

Route::middleware(['verify.api.token'])->group(function () {
    //Admin
    Route::get('/tiket', [TicketController::class, 'index']);
    Route::put('/tiket/{id}', [TicketController::class, 'update']);
    Route::delete('/tiket/{id}', [TicketController::class, 'destroy']);

    Route::get('/histori', [HistoriController::class, 'index']);
    Route::get('/histori/{id}', [HistoriController::class, 'show']);
    Route::post('/histori', [HistoriController::class, 'store']);
    Route::delete('/histori/{id}', [HistoriController::class, 'destroy']);
    Route::get('/histori/search/{id_transaksi}', [HistoriController::class, 'search']);

    //USER
    Route::post('/cart', [CartController::class, 'store']);
    Route::delete('/cart/{id_cart}', [CartController::class, 'destroy']);
    Route::post('/cart/checkout', [CartController::class, 'checkout']);

    Route::post('/bayar', [PembayaranController::class, 'bayar']);

    Route::get('/pembelian/{pengunjung}', [PembelianController::class, 'histori_pembelian']);
});

Route::get('/generate-qrcode/{data}', [QrCodeController::class, 'generateQrCode'])->name('api.generate-qrcode');;
Route::get('/show-qrcode/{data}', [QrCodeController::class, 'showQrCode']);