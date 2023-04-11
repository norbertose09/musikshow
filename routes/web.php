<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use App\Http\Controllers\paymentController;

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
Route::any('/', [paymentController::class, 'index']);

Route::any('/payconfig', [paymentController::class, 'makePayment']);

Route::any('/successful', [paymentController::class, 'callBack'])->name('pages.callback');

Route::any('/admin/dashboard', [adminController::class, 'dashboard'])->middleware('auth');

Route::any('/admin/signin', [adminController::class, 'signin'])->name('login');

Route::any('/admin/register', [adminController::class, 'register'])->middleware('auth');

Route::any('/registerconfig', [adminController::class, 'create'])->middleware('auth');

Route::any('/logout', [adminController::class, 'logout'])->middleware('auth');

Route::any('/loginconfig', [adminController::class, 'login']);
