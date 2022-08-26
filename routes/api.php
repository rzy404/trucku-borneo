<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController as Cust;

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

Route::post('/login', [Cust::class, 'login']);

// Route::resource('/data-aja', Cust::class);

// Route::get('/data', [Cust::class, 'index']);
// Route::get('/test', function () {
//     return "test";
// });

// Route::group(['middleware' => ['auth:sanctum']], function () {
// });

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Route::get('/profile', function (Request $request) {
    //     return auth()->user();
    // });

    Route::get('/test', function () {
        return "test";
    });

    // API route for logout user
    Route::post('/logout', [Cust::class, 'logout']);
});
