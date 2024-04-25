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
Route::get('/analytics', [App\Http\Controllers\HomeController::class, 'analytics'])->name('analytics');
Route::get('/plan-budget-allocations', [App\Http\Controllers\HomeController::class, 'providerBudgetAllocations'])->name('provider.budget.allocation');
Route::get('/calim/{claim}/invoice/download', [App\Http\Controllers\HomeController::class, 'claimInvoiceDownload'])->name('claim.invoice.download');
Route::get('/plan/{file_name}', [App\Http\Controllers\HomeController::class, 'planFileDownload'])->name('plan.file.download');
Route::get('/job-test', [App\Http\Controllers\HomeController::class, 'jobTest'])->name('job.test');
