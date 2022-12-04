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
    Route::post('/update-profile', [Home::class, 'UpdateProfile']);
    Route::post('/change-password', [Home::class, 'ChangePassword']);
    Route::post('/change-avatar', [Home::class, 'ChangeAvatar']);
    Route::post('/update-perusahaan/{id}', [profile::class, 'updatePerusahaan']);

    //route truck
    Route::get('/truck', [Home::class, 'GetTruck']);

    //route transaksi
    Route::post('/transaksi/{perusahaan}/{jenis_truk}', [transaksi::class, 'transaksi']);
});
