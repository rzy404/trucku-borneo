<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController as Auth;
use App\Http\Controllers\API\HomeController as Home;
use App\Http\Controllers\API\ProfileController as Profile;
use App\Http\Controllers\API\TransaksiController as transaksi;

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

Route::post('register', [Auth::class, 'register']);
Route::post('login', [Auth::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [Auth::class, 'logout']);

    //route profile
    Route::get('/detail-profile', [Home::class, 'GetProfile']);
    Route::post('/update-profile', [Profile::class, 'UpdateProfile']);
    Route::post('/change-password', [Profile::class, 'changePassword']);
    Route::post('/change-avatar', [Profile::class, 'changeAvatar']);

    //route truck
    Route::get('/truck', [Home::class, 'GetTruck']);
    Route::get('/armada', [Home::class, 'GetJenisTruk']);

    //route transaksi
    Route::post('/transaksi', [transaksi::class, 'transaksi']);
    Route::post('/upload-bukti', [transaksi::class, 'uploadBuktiBayar']);
    Route::get('/history-pemesanan', [transaksi::class, 'getTransaksiByCostumer']);

    //route get metode pembayaran
    Route::get('/metode-pembayaran', [Home::class, 'GetMetodePembayaran']);

    //route get no rekening pembayaran berdasarkan id metode pembayaran
    Route::post('/no-rekening', [Home::class, 'GetNoRekening']);
});
