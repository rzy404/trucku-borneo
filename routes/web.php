<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Auth\LoginController as Login;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\OperatorController as Operator;
use App\Http\Controllers\Admin\CostumerController as Costu;
use App\Http\Controllers\Admin\SopirController as Driver;
use App\Http\Controllers\Admin\TruckController as truk;
// use App\Http\Controllers\RoleController;
// use App\Http\Controllers\UserController;
// use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false]);
Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/', [AdminDashboard::class, 'getProfile'])->name('detail');
    Route::post('/update', [AdminDashboard::class, 'updateProfile'])->name('update');
    Route::post('/change-password', [AdminDashboard::class, 'changePassword'])->name('change-password');
    Route::post('/change-avatar', [AdminDashboard::class, 'changeAvatar'])->name('change-avatar');
});

Route::prefix('user')->name('user.')->middleware('auth')->group(function () {

    //route operator
    Route::prefix('operator')->name('operator.')->group(function () {
        Route::get('/', [Operator::class, 'index'])->name('index');
        Route::post('/create', [Operator::class, 'store'])->name('create');
        Route::get('/edit/{id}', [Operator::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [Operator::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [Operator::class, 'delete'])->name('delete');
    });

    //route costumer
    Route::prefix('costumer')->name('cost.')->group(function () {
        Route::get('/', [Costu::class, 'index'])->name('index');
        Route::post('/create', [Costu::class, 'store'])->name('create');
        Route::get('/view/{id}', [Costu::class, 'show'])->name('view');
        Route::post('/update_status/{id}', [Costu::class, 'updateStatus'])->name('update_status');
        Route::delete('/delete/{id}', [Costu::class, 'delete'])->name('delete');
    });

    // route driver
    Route::prefix('driver')->name('driver.')->group(function () {
        Route::get('/', [Driver::class, 'index'])->name('index');
        Route::post('/create', [Driver::class, 'store'])->name('create');
        Route::get('/view/{id}', [Driver::class, 'show'])->name('view');
        Route::get('/edit/{id}', [Driver::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [Driver::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [Driver::class, 'delete'])->name('delete');
    });
});

// route truck
Route::prefix('data-truck')->name('truk.')->middleware('auth')->group(function () {
    Route::get('/', [truk::class, 'index'])->name('index');
    Route::post('/create', [truk::class, 'store'])->name('create');
    Route::get('/edit/{id}', [truk::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [truk::class, 'update'])->name('update');
    Route::get('/view/{id}', [truk::class, 'show'])->name('view');
    // Route::post('/update-driver/truk?={id_truk}&driver?={id_driver}', [truk::class, 'updateDriver'])->name('update-driver');
    Route::post('/update-driver/{id_truk}/{id_driver}', [truk::class, 'updateDriver'])->name('update-driver');
    Route::delete('/delete/{id}', [truk::class, 'delete'])->name('delete');
});

// route metode-pembayaran
Route::prefix('metode-pembayaran')->name('metodepb.')->middleware('auth')->group(function () {
});

// route transaksi
Route::prefix('transaksi')->name('transaksi.')->middleware('auth')->group(function () {
});

// Route::group(['middleware' => ['auth']], function () {
//     Route::resource('roles', RoleController::class);
//     Route::resource('users', UserController::class);
//     Route::resource('products', ProductController::class);
// });

    // Route::group(['middleware' => ['auth']], function () {
    //     Route::resource('roles', RoleController::class);
    //     Route::resource('users', UserController::class);
    // });
