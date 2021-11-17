<?php

use Illuminate\Support\Facades\Route;

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
    return redirect()->route('home');
})->name('index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/my-account', [App\Http\Controllers\HomeController::class, 'myAccount'])->name('my.account');
Route::get('/calim/{claim}/invoice/download', [App\Http\Controllers\HomeController::class, 'claimInvoiceDownload'])->name('claim.invoice.download');
